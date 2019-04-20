<template>
  <v-layout row>
    <v-flex xs12>
      <v-list>
        <v-toolbar color="white" flat fixed>
          <v-btn href="/driver/home" icon light>
            <v-icon color="grey darken-2">arrow_back</v-icon>
          </v-btn>
          <v-toolbar-title class="title font-weight-thin">Bus No.: {{ driver.bus_id }}</v-toolbar-title>
        </v-toolbar>


        <v-subheader class="mt-1"></v-subheader>

        <!-- Message Here -->


        <v-flex class="mr-4 ml-4">
          <v-list v-for="messages in allMessages" :key="messages.id">

            <!-- driver Message -->
               <v-flex xs8 offset-xs6>
            <div class="text-xs-right">
              <div style="word-wrap: break-word;" v-if="messages.driver_message">
                <div style="font-family:Roboto, sans-serif; font-size: 12px;" class="font-weight-light">Driver: {{messages.driver.fname}}</div>
                        <v-card flat color="blue-grey lighten-5">
                        <v-card-text class="title font-weight-thin">{{messages.driver_message}}</v-card-text>
                        </v-card>
                <div style="font-family:Roboto, sans-serif; font-size: 10px;" class="font-weight-light">{{messages.created_at}}</div>
              </div>
            </div>
        </v-flex>

            <!-- Student Message -->
        <v-flex xs5>
            <div class="text-xs-left">
              <div style="word-wrap: break-word;" v-if="messages.student_message">
                <div style="font-family:Roboto, sans-serif; font-size: 12px;" class="font-weight-light">Student: {{messages.student.fname}}</div>
                        <v-card flat color="blue-grey lighten-5">
                        <v-card-text class="title font-weight-thin">{{messages.student_message}}</v-card-text>
                        </v-card>
                <div style="font-family:Roboto, sans-serif; font-size: 10px;" class="font-weight-light">{{messages.created_at}}</div>
              </div>
            </div>
        </v-flex>


          </v-list>
        </v-flex>


        <!-- Message Here -->

        <v-subheader class="mb-3"></v-subheader>
      </v-list>
    </v-flex>

    <!-- Input Message -->
    <v-footer height="auto" fixed>
      <v-flex xs12 class="ml-4">
        <v-text-field
          clearable
          label="Enter Message"
          v-model="message"
          @keyup.enter="sendMessages"
          class="title font-weight-thin"
        ></v-text-field>
      </v-flex>

      <v-flex class="mr-4">
        <v-btn
          @click="sendMessages()"
          @click:clear="clearMessage"
          fab
          dark
          small
          color="blue-grey darken-4"
        >
          <v-icon dark>send</v-icon>
        </v-btn>
      </v-flex>
    </v-footer>
  </v-layout>
</template>


<script>
export default {
    props: {
        driver: {
            type: Object,
            required: true
        }
    },
  data() {
    return {
      message: null,
      allMessages: []
    };
  },

  created() {
    this.fetchMessages();

    Echo.channel("messages-sent."+this.driver.bus_id).listen( "SentMessage",
      e => {
        this.allMessages.push({ student: e.message.student, student_message: e.message.student_message, created_at: e.message.created_at });
        setTimeout(this.scrollToEnd, 100);
      }
    );

  },

  methods: {

    sendMessages() {
      axios.post('/driver/student/message', { message: this.message })
      .then(response => {
        this.allMessages.push({ driver: response.data.message.driver, driver_message: response.data.message.driver_message, created_at: response.data.message.created_at });
        setTimeout(this.scrollToEnd, 100);
      });
      this.clearMessage();
    },

    fetchMessages() {
      axios.get('/driver/student/message/recieve')
      .then(response => {
        this.allMessages = response.data.message;
        setTimeout(this.scrollToEnd, 100);
      });
    },

    scrollToEnd() {
      window.scrollTo(0, 99999);
    },

    clearMessage() {
      this.message = "";
    }
  }
};
</script>
