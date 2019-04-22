<template>
  <v-layout row>
    <v-flex xs12>
      <v-list>
        <v-toolbar color="white" flat fixed>
          <v-btn href="/guardian/home" icon light>
            <v-icon color="grey darken-2">arrow_back</v-icon>
          </v-btn>
          <v-toolbar-title class="title font-weight-thin">{{ guardian.fname }} {{guardian.lname}}</v-toolbar-title>
        </v-toolbar>
        <v-subheader class="mt-1"></v-subheader>

        <!-- Notifications Here -->
        <v-flex class="mr-4 ml-4">
          <v-list v-for="notification in allNotifications" :key="notification.id">
            <!-- driver Notification recieves-->
            <v-flex xs8 offset-xs6>
              <div class="text-xs-center">
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
              </div>
            </v-flex>
          </v-list>
        </v-flex>
        <v-subheader class="mb-3"></v-subheader>
      </v-list>
    </v-flex>
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
    this.fetchNotifications();

    Echo.channel("notification-sent."+this.guardian.id).listen( "Notifications",
      e => {
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
      axios.get('/guardian/guardianNotifications')
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
