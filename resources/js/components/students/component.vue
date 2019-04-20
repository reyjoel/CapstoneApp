<template>
  <v-layout wrap>
    <!-- Toolbar -->
    <v-toolbar flat dense floating class="transparent ma-0" app>
    <v-toolbar-side-icon @click="drawer = !drawer"></v-toolbar-side-icon>
  </v-toolbar>
    <!-- Navbar -->
    <v-navigation-drawer v-model="drawer" app class="grey lighten-4">
    <!-- Profile -->
      <v-toolbar flat class="yellow accent-4 pa-3 ma-0">
        <v-list class="pa-0 ma-0">
          <v-list-tile avatar href="/student/profile">
    <!-- Profile Image -->
            <v-avatar color="blue-grey darken-4">
              <v-icon dark>account_circle</v-icon>
            </v-avatar>
    <!-- Profile Name -->
            <v-list-tile-content class="pl-3">
              <v-list-tile-title class="title font-weight-light" v-for="student in students" :key="student.id">
                {{ student.fname }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-toolbar>
    <!-- Notification Icon -->
      <v-list class="pa-0" dense>
        <v-list-tile class="pt-1" href="/student/notification">
          <v-list-tile-action>
            <v-icon>notifications_none</v-icon>
          </v-list-tile-action>
    <!-- Notification Title -->
          <v-list-tile-content>
            <v-list-tile-title class="title font-weight-thin">Notifications</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
      <!-- Driver Icon -->
      <v-list class="pa-0" dense>
        <v-list-tile class="pt-1" href="/student/driver">
          <v-list-tile-action>
            <v-icon>person</v-icon>
          </v-list-tile-action>
    <!-- Driver Title -->
          <v-list-tile-content>
            <v-list-tile-title class="title font-weight-thin">My Driver</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    <!-- Logout -->
      <v-toolbar flat>
        <v-list>
          <v-list-tile @click.prevent="logout" avatar>
            <v-list-tile-action>
              <v-icon>exit_to_app</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title class="title font-weight-thin">Logout</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-toolbar>
    </v-navigation-drawer>

  </v-layout>
</template>

<script>
export default {
  data() {
    return {
      drawer: false,
      students: []
    }
  },
  created() {
       axios
        .get('/student/home/studentinfo')
        .then(response => this.students = response.data.students);
  },
  methods: {
    logout() {
      axios
        .get('/student/logout')
        .then(function(response) {});
        window.location.replace('/student/login');
    }
  }
};
</script>
