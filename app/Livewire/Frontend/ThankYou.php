<?php

namespace App\Livewire\Frontend;

use App\Jobs\CompletePurchaseJob;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\Courses\Models\Course;
use Modules\Courses\Models\Enrollment;
use Nwidart\Modules\Facades\Module;

class ThankYou extends Component
{
    public $orderId;

    public function mount($id)
    {
        $this->orderId = $id;
        $this->ensurePurchaseCompleted();
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        $orderItems = $this->getOrderItems();

        if ($orderItems->isEmpty()) {
            abort(404);
        }

        return view('livewire.frontend.thank-you', [
            'orderItem'    => $orderItems,
            'subtotal'     => $orderItems->sum(fn (OrderItem $item) => (float) $item->price * (float) $item->quantity),
            'discount'     => $orderItems->sum(fn (OrderItem $item) => (float) ($item->discount_amount ?? 0)),
            'grandTotal'   => $orderItems->sum(fn (OrderItem $item) => (float) $item->total),
            'continueUrl'  => $this->resolveContinueUrl($orderItems),
            'continueLabel'=> $this->resolveContinueLabel($orderItems),
        ]);
    }

    protected function getOrderItems(): Collection
    {
        $morphWith = [
            Course::class => ['thumbnail'],
        ];

        if (Module::has('CourseBundles') && Module::isEnabled('CourseBundles')) {
            $morphWith[\Modules\CourseBundles\Models\Bundle::class] = ['thumbnail'];
        }

        return OrderItem::where('order_id', $this->orderId)
            ->with([
                'orderable' => function ($morphTo) use ($morphWith) {
                    $morphTo->morphWith($morphWith);
                },
            ])
            ->get();
    }

    protected function ensurePurchaseCompleted(): void
    {
        $order = Order::with('items')->find($this->orderId);

        if (empty($order) || $order->status !== 'complete') {
            return;
        }

        $needsCompletion = $order->items->contains(function ($item) use ($order) {
            if ($item->orderable_type === Course::class) {
                return !Enrollment::where('student_id', $order->user_id)
                    ->where('course_id', $item->orderable_id)
                    ->exists();
            }

            return false;
        });

        if ($needsCompletion) {
            Bus::dispatchNow(new CompletePurchaseJob($order));
        }
    }

    protected function resolveContinueUrl(Collection $orderItems): string
    {
        $types = $orderItems->pluck('orderable_type')->unique();

        if ($types->contains(Course::class)) {
            return route('courses.course-list');
        }

        if (
            Module::has('TrainingCalendar')
            && Module::isEnabled('TrainingCalendar')
            && $types->contains(\Modules\TrainingCalendar\Models\TrainingCalendar::class)
        ) {
            return route('trainingcalendar.student.my-trainings');
        }

        return auth()->user()?->role === 'student'
            ? route('student.profile.personal-details')
            : route('tutor.invoices');
    }

    protected function resolveContinueLabel(Collection $orderItems): string
    {
        $types = $orderItems->pluck('orderable_type')->unique();

        if ($types->contains(Course::class)) {
            return __('thank_you.continue_my_learning');
        }

        if (
            Module::has('TrainingCalendar')
            && Module::isEnabled('TrainingCalendar')
            && $types->contains(\Modules\TrainingCalendar\Models\TrainingCalendar::class)
        ) {
            return __('thank_you.continue_my_trainings');
        }

        return __('thank_you.continue_profile');
    }
}
