<template>
    <v-layout row>
        <v-btn href="/driver/home" icon light>
            <v-icon color="grey darken-2">arrow_back</v-icon>
        </v-btn>
        <div>
            <div class="text-xs-center mt-3">
                <v-btn round large color="blue-grey darken-4" class="title font-weight-thin" @click="sendNotifyDriver()" dark>Sick</v-btn>
            </div>
        </div>
    </v-layout>
</template>

<script>
export default {
    props: {
        guardian: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            notification: null,
            allNotifications: []
        };
    },
    created() {
        Echo.channel("notification-sent."+this.guardian.id).listen( "Notifications",
            e => {
                console.log(e)
                var obj = {
                id            : e.notifications.id,
                notifier      : e.notifications.notifier,
                notifier_id   : e.notifications.notifier_id,
                notify_to_id  : e.notifications.notify_to_id,
                notify_to     : e.notifications.notify_to,
                g_fname       : e.notifications.g_fname,
                g_lname       : e.notifications.g_lname,
                stu_fname     : e.notifications.stu_fname,
                stu_lname     : e.notifications.stu_lname,
                created_at    : e.notifications.created_at,
                updated_at    : e.notifications.updated_at,
                }
                this.allNotifications.push(obj);
                setTimeout(this.scrollToEnd, 100);
            }
        );
    },
    methods: {
        sendNotifyDriver() {
            axios.post('/guardian/notifyDriver', { id: this.guardian.id })
                .then(response => {
                    alert(response.data.status);
                    setTimeout(this.scrollToEnd, 100);
                });
        }
    }
};
</script>