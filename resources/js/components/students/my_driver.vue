<template>
  <div>
    <!-- BACKGROUND COLOR -->
    <div class="blue-grey lighten-5">
      <!-- BACK ARROW ICON -->
      <v-toolbar flat dense floating class="transparent ma-0">
        <v-list class="transparent">
          <v-list-tile v-for="link in links" :key="link.text" href="/student/home">
            <v-list-tile-action>
              <v-icon class="grey--text text--darken-4">{{ link.icon }}</v-icon>
            </v-list-tile-action>
          </v-list-tile>
        </v-list>
      </v-toolbar>
      <!-- DRIVER ICON -->
      <div class="text-xs-center" v-for="driver in driver" :key="driver.id">
        <v-avatar size="100" color="blue-grey darken-4">
          <v-icon size="60" dark>account_circle</v-icon>
        </v-avatar>
        <!-- DRIVER NAME -->
        <p class="title font-weight-light py-3">{{ driver.fname }} {{ driver.lname }}</p>
      </div>
    </div>
    <!-- DRIVER INFO -->
    <div class="text-xs-center subheader font-weight-light py-3" v-for="driver in driver" :key="driver.id">
      <p class="title font-weight-thin mb-4">Bus No.: {{ driver.bus_id }}</p>

    </div>
    <div class="text-xs-center">

        <!-- RATINGS -->
      <v-rating
        color="yellow darken-3"
        background-color="grey darken-1"
        empty-icon="$vuetify.icons.ratingFull"
        half-increments
        hover ></v-rating>
      <v-btn round small color="blue-grey darken-4" class="title font-weight-thin" dark>Rate Now</v-btn>

    </div>
    <div class="text-xs-center mt-5">

        <!-- MESSAGE -->
      <v-btn depressed
      color="blue-grey lighten-5"
        class="title font-weight-thin"
        href="/student/driver/message">Messages</v-btn>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      drawer: false,
      links: [{ icon: "arrow_back_ios" }],
      driver: []
    };
  },
  created() {
       axios
        .get('/student/driver/driverinfo')
        .then(response => this.driver = response.data.driver);
  }
};
</script>
