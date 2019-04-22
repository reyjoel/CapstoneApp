<template>
<div>
    <!-- Back Arrow Icon -->
    <v-toolbar flat dense floating class="transparent ma-0">
   <v-list>
    <v-list-tile href="/student/home">
         <v-list-tile-action>
            <v-icon class="grey--text text--darken-4">arrow_back_ios</v-icon>
         </v-list-tile-action>
    </v-list-tile>
   </v-list>
   </v-toolbar>
   <div class="text-xs-center">
        <p class="title font-weight-light">Notifications</p>
        <v-list v-for="notification in allNotifications" :key="notification.id">
            <div style="word-wrap: break-word;">
                {{notification.id}}
                <div style="font-family:Roboto, sans-serif; font-size: 12px;" class="font-weight-light">
                    Sender: driver {{notification.notifier_id}}
                </div>
                <v-card flat color="blue-grey lighten-5">
                    <v-card-text class="title font-weight-thin">The driver of bus no. {{notification.notify_to_id}} notify you that the bus was flat.</v-card-text>
                </v-card>
                <div style="font-family:Roboto, sans-serif; font-size: 10px;" class="font-weight-light">
                    {{notification.created_at}}
                </div>
            </div>
        </v-list>
   </div>
</div>
</template>

<script>
export default {
    props: {
        student: {
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
    this.fetchNotifications();
    
    Echo.channel("notification-sent."+this.student.bus_id).listen( "Notifications",
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
    
    fetchNotifications() {
      axios.get('/student/studentNotifications')
      .then(response => {
        this.allNotifications = response.data.notification;
        setTimeout(this.scrollToEnd, 100);
      });
    },

    scrollToEnd() {
      window.scrollTo(0, 99999);
    },
  }
};
</script>
