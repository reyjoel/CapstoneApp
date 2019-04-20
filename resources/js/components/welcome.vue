<template>
<div>
    <v-layout align-center column justify-center  class="hidden-sm-and-down">
      <h1 class="display-2 font-weight-thin pt-5 mt-5">Welcome To Iskul Bus Ko</h1>
    </v-layout>

    <v-layout align-center column justify-center  class="hidden-md-and-up">
      <h1 class="headline font-weight-thin pt-5 mt-5">Welcome To Iskul Bus Ko</h1>
    </v-layout>

    <v-layout align-center column justify-center>
      <h1 class="title font-weight-thin pt-2 mt-5">Login as:</h1>
    </v-layout>

    <div class="text-xs-center mt-3">
    <v-btn round large color="blue-grey darken-4" class="title font-weight-thin" href="/driver/home" dark>Driver</v-btn>
  </div>
  <div class="text-xs-center mt-2">
    <v-btn round large color="blue-grey darken-4" class="title font-weight-thin" href="/student/home" dark>Student</v-btn>
  </div>
  <div class="text-xs-center mt-2">
    <v-btn round large color="blue-grey darken-4" class="title font-weight-thin" href="/guardian/home" dark>Guardian</v-btn>
  </div>
</div>
</template>

