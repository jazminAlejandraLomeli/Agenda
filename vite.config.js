import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/calendar.css',
                'resources/css/gridJs.css',
                'resources/css/tomSelect.css',
                'resources/js/app.js',
                'resources/js/agenda-cta.js',
                'resources/js/agenda-guest.js',
                'resources/js/agenda-protocolo.js',
                'resources/js/agenda-superadmin.js',
                'resources/js/confirm-classroom.js',
                'resources/js/create-event-cta.js',
                'resources/js/create-event-protocolo.js',
                'resources/js/create-user.js',
                'resources/js/edit-event-cta.js',
                'resources/js/edit-event-protocolo.js',
                'resources/js/edit-events-cta.js',
                'resources/js/edit-events-protocolo.js',
                'resources/js/manage-classrooms.js',
                'resources/js/users.js',
                'resources/js/manage/super-event-types.js',
                'resources/js/manage/super-dependencies.js',
                'resources/js/manage/places.js',
            //    'resources/js/helpers/select2.min.js',
                'resources/js/components/deleteEvent.js',
                'resources/js/profile/profile.js',
                'resources/js/create-guest-event-cta.js',
                'resources/js/update-user.js',
                'resources/js/statistics/events.js'
            ],
            refresh: true,
        }),
    ],
});
