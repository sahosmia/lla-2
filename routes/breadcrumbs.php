<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


$roleInfo = getUserRole();

$role = !empty($roleInfo) ? $roleInfo['roleName'] : '';

Breadcrumbs::for('tutor.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push(__('general.dashboard'), route('tutor.dashboard'));
    $trail->push(__('general.my_earnings'), route('tutor.dashboard'));
});

if($role != 'admin'){
    Breadcrumbs::for($role.'.profile', function (BreadcrumbTrail $trail) use ($role): void {
        $trail->push(__('general.profile_settings'), route($role.'.profile.personal-details'));
    });

    Breadcrumbs::for($role.'.profile.personal-details', function (BreadcrumbTrail $trail) use ($role): void {
        $trail->parent($role.'.profile');
        $trail->push(__('profile.personal_details'), route($role.'.profile.personal-details'));
    });

    Breadcrumbs::for($role.'.profile.account-settings', function (BreadcrumbTrail $trail) use ($role): void {
        $trail->parent($role.'.profile');
        $trail->push(__('profile.account_settings'), route($role.'.profile.account-settings'));
    });
}

Breadcrumbs::for('tutor.profile.resume.education', function (BreadcrumbTrail $trail) {
    $trail->parent('tutor.profile');
    $trail->push(__('education.title'), route('tutor.profile.resume.education'));
});

Breadcrumbs::for('tutor.profile.resume.experience', function (BreadcrumbTrail $trail) {
    $trail->parent('tutor.profile');
    $trail->push(__('experience.title'), route('tutor.profile.resume.experience'));
});

Breadcrumbs::for('tutor.profile.resume.certificate', function (BreadcrumbTrail $trail) {
    $trail->parent('tutor.profile');
    $trail->push(__('certificate.certificate_wards'), route('tutor.profile.resume.certificate'));
});

Breadcrumbs::for($role.'.profile.identification', function (BreadcrumbTrail $trail) use($role){
    $trail->parent($role.'.profile');
    $trail->push(__('identity.title'), route($role.'.profile.identification'));
});


Breadcrumbs::for('student.billing-detail', function (BreadcrumbTrail $trail) {
    $trail->push(__('sidebar.billing_detail'), route('student.billing-detail'));
});

Breadcrumbs::for($role.'.invoices', function (BreadcrumbTrail $trail) use ($role) {
    if($role == 'admin'){
        $trail->parent('admin.insights');
    } elseif($role == 'tutor') {
        $trail->push(__('general.dashboard'), route('tutor.dashboard'));
    }elseif($role == 'student') {
        $trail->push(__('general.profile_settings'), route('student.profile.personal-details'));
    }
    $trail->push(__('sidebar.invoices'), route($role.'.invoices'));
});

Breadcrumbs::for('student.favourites', function (BreadcrumbTrail $trail) {
    $trail->push(__('general.profile_settings'), route('student.profile.personal-details'));
    $trail->push(__('sidebar.favourites'), route('student.favourites'));
});

Breadcrumbs::for('laraguppy.messenger', function (BreadcrumbTrail $trail) use ($role) {
    if($role == 'tutor'){
        $trail->push(__('general.dashboard'), route('tutor.dashboard'));
    }elseif($role == 'student') {
        $trail->push(__('general.profile_settings'), route('student.profile.personal-details'));
    }
    $trail->push(__('sidebar.messages'), route('laraguppy.messenger'));
});

Breadcrumbs::for('tutor.payouts', function (BreadcrumbTrail $trail) use ($role) {
    $trail->push(__('general.dashboard'), route('tutor.dashboard'));
    $trail->push(__('tutor.payouts_history'), route('tutor.payouts'));
});
Breadcrumbs::for('admin.insights', function (BreadcrumbTrail $trail) {
    $trail->push(__('general.insights'), route('admin.insights'));
});

Breadcrumbs::for('admin.manage-menus', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.manage_menus'), route('admin.manage-menus'));
});

Breadcrumbs::for('optionbuilder', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.global_settings'), route('optionbuilder'));
});

Breadcrumbs::for('pagebuilder', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.site_pages'), route('pagebuilder'));
});

Breadcrumbs::for('admin.email-settings', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('sidebar.email_templates'), route('admin.email-settings'));
});

Breadcrumbs::for('admin.notification-settings', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('sidebar.notification_templates'), route('admin.notification-settings'));
});

Breadcrumbs::for('admin.taxonomy.languages', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.languages'), route('admin.taxonomy.languages'));
});

Breadcrumbs::for('admin.taxonomy.subjects', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.subjects'), route('admin.taxonomy.subjects'));
});

Breadcrumbs::for('admin.taxonomy.subject-groups', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.subject_groups'), route('admin.taxonomy.subject-groups'));
});

Breadcrumbs::for('admin.language-translator', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.translations'), route('admin.language-translator'));
});

Breadcrumbs::for('ltu.translation.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.translations'), route('ltu.translation.index'));
});

Breadcrumbs::for('admin.packages.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('sidebar.add_new_package'), route('admin.packages.index'));
});

Breadcrumbs::for('admin.packages.installed', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('sidebar.installed_packages'), route('admin.packages.installed'));
});

Breadcrumbs::for('admin.upgrade', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.upgrade'), route('admin.upgrade'));
});

Breadcrumbs::for('admin.manage-admin-users', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.admins'), route('admin.manage-admin-users'));
});

Breadcrumbs::for('admin.users', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.users'), route('admin.users'));
});

Breadcrumbs::for('admin.identity-verification', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.identity_verification'), route('admin.identity-verification'));
});

Breadcrumbs::for('admin.reviews', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('admin/sidebar.reviews'), route('admin.reviews'));
});

Breadcrumbs::for('admin.withdraw-requests', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.withdraw_requests'), route('admin.withdraw-requests'));
});

Breadcrumbs::for('admin.commission-settings', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.commission_settings'), route('admin.commission-settings'));
});

Breadcrumbs::for('admin.payment-methods', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.payment_methods'), route('admin.payment-methods'));
});

Breadcrumbs::for('admin.create-blog', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.create_blog'), route('admin.create-blog'));
});

Breadcrumbs::for('admin.blog-listing', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.blog_listing'), route('admin.blog-listing'));
});

Breadcrumbs::for('admin.blog-categories', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.blog_categories'), route('admin.blog-categories'));
});

Breadcrumbs::for('admin.profile', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.insights');
    $trail->push(__('general.profile'), route('admin.profile'));
});

if(\Nwidart\Modules\Facades\Module::has('forumwise') &&\Nwidart\Modules\Facades\Module::isEnabled('forumwise')){
    Breadcrumbs::for('forums', function (BreadcrumbTrail $trail) use ($role) {
        if($role == 'admin'){       
            $trail->parent('admin.insights');
        }elseif($role == 'tutor') {
            $trail->push(__('general.dashboard'), route('tutor.dashboard'));
        }elseif($role == 'student') {
            $trail->push(__('general.profile_settings'), route('student.profile.personal-details'));
        }
        $trail->push(__('general.forums'), route('forums'));
    });

    Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) {
        $trail->parent('forums');
        $trail->push(__('general.categories'), route('categories'));
    });
}   

if(\Nwidart\Modules\Facades\Module::has('Subscriptions') &&\Nwidart\Modules\Facades\Module::isEnabled('Subscriptions')){
    Breadcrumbs::for('admin.subscriptions.index', function (BreadcrumbTrail $trail) use ($role) {
        if($role == 'admin'){  
            $trail->parent('admin.insights');
        }
        $trail->push(__('subscriptions::subscription.subscription_title'), route('admin.subscriptions.index'));
    });

    Breadcrumbs::for('admin.subscriptions.purchased', function (BreadcrumbTrail $trail) {
        $trail->parent('admin.insights');
        $trail->push(__('subscriptions::subscription.purchased_subscriptions'), route('admin.subscriptions.purchased'));
    });
}

if(\Nwidart\Modules\Facades\Module::has('Courses') &&\Nwidart\Modules\Facades\Module::isEnabled('Courses')){
    Breadcrumbs::for('courses.admin.courses', function (BreadcrumbTrail $trail) {
        $trail->parent('admin.insights');
        $trail->push(__('courses::courses.courses'), route('courses.admin.courses'));
    });

    Breadcrumbs::for('courses.admin.categories', function (BreadcrumbTrail $trail) {
        $trail->parent('admin.insights');
        $trail->push(__('courses::courses.categories'), route('courses.admin.categories'));
    });

    Breadcrumbs::for('courses.admin.course-enrollments', function (BreadcrumbTrail $trail) {
        $trail->parent('admin.insights');
        $trail->push(__('courses::courses.course_enrollments'), route('courses.admin.course-enrollments'));
    });

    Breadcrumbs::for('courses.admin.commission-setting', function (BreadcrumbTrail $trail) {
        $trail->parent('admin.insights');
        $trail->push(__('courses::courses.commission_settings'), route('courses.admin.commission-setting'));
    });

    Breadcrumbs::for('courses.course-list', function (BreadcrumbTrail $trail) {
        $trail->push(__('general.profile_settings'), route('student.profile.personal-details'));
        $trail->push(__('courses::courses.courses'), route('courses.course-list'));
    });

    Breadcrumbs::for('courses.tutor.courses', function (BreadcrumbTrail $trail) {
        $trail->push(__('general.dashboard'), route('tutor.dashboard'));
        $trail->push(__('courses::courses.courses'), route('courses.tutor.courses'));
    });
}

if(\Nwidart\Modules\Facades\Module::has('CourseBundles') &&\Nwidart\Modules\Facades\Module::isEnabled('CourseBundles')){
    Breadcrumbs::for('coursebundles.tutor.bundles', function (BreadcrumbTrail $trail) {
        $trail->push(__('general.dashboard'), route('tutor.dashboard'));
        $trail->push(__('coursebundles::bundles.course_bundles'), route('coursebundles.tutor.bundles'));
    });
}

if(\Nwidart\Modules\Facades\Module::has('IPManager') &&\Nwidart\Modules\Facades\Module::isEnabled('IPManager')){
    Breadcrumbs::for('ipmanager.admin.login-history', function (BreadcrumbTrail $trail) {
        $trail->parent('admin.insights');
        $trail->push(__('ipmanager::ipmanager.login_history'), route('ipmanager.admin.login-history'));
    });

    Breadcrumbs::for('ipmanager.admin.ip-restriction', function (BreadcrumbTrail $trail) {
        $trail->parent('admin.insights');
        $trail->push(__('ipmanager::ipmanager.ip_restriction'), route('ipmanager.admin.ip-restriction'));
    });
}

if(\Nwidart\Modules\Facades\Module::has('starup') &&\Nwidart\Modules\Facades\Module::isEnabled('starup')){
    Breadcrumbs::for('badges.badge-list', function (BreadcrumbTrail $trail) {
        $trail->parent('admin.insights');
        $trail->push(__('starup::starup.badges'), route('badges.badge-list'));
    });
}

if(\Nwidart\Modules\Facades\Module::has('Quiz') &&\Nwidart\Modules\Facades\Module::isEnabled('Quiz')){
    Breadcrumbs::for('quiz.student.quizzes', function (BreadcrumbTrail $trail) {
        $trail->push(__('general.profile_settings'), route('student.profile.personal-details'));
        $trail->push(__('quiz::quiz.quizzes'), route('quiz.student.quizzes'));
    });

    Breadcrumbs::for('quiz.tutor.quizzes', function (BreadcrumbTrail $trail) {
        $trail->push(__('general.dashboard'), route('tutor.dashboard'));
        $trail->push(__('quiz::quiz.manage_quizzes'), route('quiz.tutor.quizzes'));
    });
}

if(\Nwidart\Modules\Facades\Module::has('Assignments') &&\Nwidart\Modules\Facades\Module::isEnabled('Assignments')){
    Breadcrumbs::for('assignments.student.student-assignments', function (BreadcrumbTrail $trail) {
        $trail->push(__('general.profile_settings'), route('student.profile.personal-details'));
        $trail->push(__('assignments::assignments.assignments'), route('assignments.student.student-assignments'));
    });

    Breadcrumbs::for('assignments.tutor.assignments-list', function (BreadcrumbTrail $trail) {
        $trail->push(__('general.dashboard'), route('tutor.dashboard'));
        $trail->push(__('assignments::assignments.assignments'), route('assignments.tutor.assignments-list'));
    });
}

if(\Nwidart\Modules\Facades\Module::has('Upcertify') &&\Nwidart\Modules\Facades\Module::isEnabled('Upcertify')){
    Breadcrumbs::for('student.certificate-list', function (BreadcrumbTrail $trail) {
        $trail->push(__('general.profile_settings'), route('student.profile.personal-details'));
        $trail->push(__('sidebar.certificates'), route('student.certificate-list'));
    });

    Breadcrumbs::for('upcertify.certificate-list', function (BreadcrumbTrail $trail) {
        $trail->push(__('general.dashboard'), route('tutor.dashboard'));
        $trail->push(__('sidebar.certificates'), route('upcertify.certificate-list'));
    });
}

if(\Nwidart\Modules\Facades\Module::has('KuponDeal') &&\Nwidart\Modules\Facades\Module::isEnabled('KuponDeal')){
    Breadcrumbs::for('kupondeal.coupon-list', function (BreadcrumbTrail $trail) {
        $trail->push(__('general.dashboard'), route('tutor.dashboard'));
        $trail->push(__('kupondeal::kupondeal.coupons'), route('kupondeal.coupon-list'));
    });
}


if(\Nwidart\Modules\Facades\Module::has('TrainingCalendar') && \Nwidart\Modules\Facades\Module::isEnabled('TrainingCalendar')){
    Breadcrumbs::for('trainingcalendar.tutor.trainings', function (BreadcrumbTrail $trail) {
        $trail->push(__('general.dashboard'), route('tutor.dashboard'));
        $trail->push(__('trainingcalendar::trainingcalendar.training_list'), route('trainingcalendar.tutor.trainings'));
    });

    Breadcrumbs::for('trainingcalendar.tutor.create', function (BreadcrumbTrail $trail) {
        $trail->parent('trainingcalendar.tutor.trainings');
        $trail->push(__('trainingcalendar::trainingcalendar.create_training'), route('trainingcalendar.tutor.create'));
    });

    Breadcrumbs::for('trainingcalendar.tutor.edit', function (BreadcrumbTrail $trail, $trainingId) {
        $trail->parent('trainingcalendar.tutor.trainings');
        $trail->push(__('trainingcalendar::trainingcalendar.edit_training'), route('trainingcalendar.tutor.edit', $trainingId));
    });

    Breadcrumbs::for('trainingcalendar.tutor.registrations', function (BreadcrumbTrail $trail, $trainingId) {
        $trail->parent('trainingcalendar.tutor.trainings');
        $trail->push(__('trainingcalendar::trainingcalendar.registrations'), route('trainingcalendar.tutor.registrations', $trainingId));
    });

    Breadcrumbs::for('trainingcalendar.tutor.send-notice', function (BreadcrumbTrail $trail, $trainingId) {
        $trail->parent('trainingcalendar.tutor.trainings');
        $trail->push(__('trainingcalendar::trainingcalendar.send_notice'), route('trainingcalendar.tutor.send-notice', $trainingId));
    });

    Breadcrumbs::for('trainingcalendar.student.my-trainings', function (BreadcrumbTrail $trail) {
        $trail->push(__('general.profile_settings'), route('student.profile.personal-details'));
        $trail->push(__('trainingcalendar::trainingcalendar.my_trainings'), route('trainingcalendar.student.my-trainings'));
    });

    Breadcrumbs::for('trainingcalendar.student.training-detail', function (BreadcrumbTrail $trail, $registrationId) {
        $trail->parent('trainingcalendar.student.my-trainings');
        $trail->push(__('trainingcalendar::trainingcalendar.event_details'), route('trainingcalendar.student.training-detail', $registrationId));
    });

    Breadcrumbs::for('trainingcalendar.admin.trainings', function (BreadcrumbTrail $trail) {
        $trail->parent('admin.insights');
        $trail->push(__('trainingcalendar::trainingcalendar.all_trainings'), route('trainingcalendar.admin.trainings'));
    });

    Breadcrumbs::for('trainingcalendar.admin.registrations', function (BreadcrumbTrail $trail) {
        $trail->parent('admin.insights');
        $trail->push(__('trainingcalendar::trainingcalendar.all_registrations'), route('trainingcalendar.admin.registrations'));
    });

    Breadcrumbs::for('trainingcalendar.admin.settings', function (BreadcrumbTrail $trail) {
        $trail->parent('admin.insights');
        $trail->push(__('trainingcalendar::trainingcalendar.module_settings'), route('trainingcalendar.admin.settings'));
    });
}
