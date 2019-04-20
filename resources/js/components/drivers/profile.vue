<template>
<div>
    <!-- BACKGROUND COLOR -->
<div class="blue-grey lighten-5">
    <!-- BACK ARROW ICON -->
      <v-toolbar flat dense floating class="transparent ma-0">
      <v-btn style="text-decoration:none;" href="/driver/home" icon light>
        <v-icon color="grey darken-2">arrow_back</v-icon>
      </v-btn>
      </v-toolbar>
   <!-- PROFILE ICON -->
        <div class="text-xs-center">
            <v-avatar size="100" color="blue-grey darken-4">
                <v-icon size="60" dark>account_circle</v-icon>
            </v-avatar>
    <!-- PROFILE NAME -->
            <p class="title font-weight-light py-3" >{{ driver.fname }} {{ driver.lname }}</p>
        </div>
</div>
    <!-- PROFILE INFO -->
        <div class="text-xs-center subheader font-weight-light py-3">
            <p class="title font-weight-thin mb-4">License No.: {{ driver.lic_num }}</p>
            <p class="title font-weight-thin">Email Address: {{ driver.email }}</p>
        </div>


  <div class="text-xs-center mt-1">
      <!--Edit Info -->
        <v-btn v-on:click="clickDriver(driver)" color="transparent" depressed style="font-size: 10px" data-toggle="modal" data-target="#editinfo">Edit Info</v-btn>


                                <div class="modal fade" id="editinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Information</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body" @keyup.enter="updateInfo">

                                <input class="mb-3 form-control" type="text" placeholder="First Name" v-model="fname">
                                <input class="mb-3 form-control" type="text" placeholder="Last Name" v-model="lname">
                                <div v-if="errorinfo">
                                <span style="color:red" v-text="errorinfo" ></span>
                                </div>

                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" v-on:click="updateInfo()">Save changes</button>
                                </div>
                                </div>
                                </div>
                                </div>

      <!--Change Email -->
        <v-btn v-on:click="clickDriver(driver)" color="transparent" depressed style="font-size: 10px" data-toggle="modal" data-target="#changeemail">Change Email</v-btn>


                                <div class="modal fade" id="changeemail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Change Email</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body" @keyup.enter="updateEmail">

                                <input class="mb-3 form-control" type="email" placeholder="Change Email" v-model="email">
                                <div v-if="erroremail">
                                <span style="color:red" v-text="erroremail" ></span>
                                </div>

                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" v-on:click="updateEmail()">Save changes</button>
                                </div>
                                </div>
                                </div>
                                </div>



      <!--Change Password -->
        <v-btn depressed style="font-size: 10px" color="transparent" data-toggle="modal" data-target="#changepassword">Change Password</v-btn>

                                <div class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body" @keyup.enter="updatePassword">

                                <input class="mb-3 form-control" type="password" placeholder="New Password" v-model="password">
                                <input class="mb-3 form-control" type="password" placeholder="Confirm Password" v-model="password_confirmation">
                                <div v-if="errorpass1">
                                <span style="color:red" v-text="errorpass1" ></span>
                                </div>
                                <div v-if="errorpass2">
                                <span style="color:red" v-text="errorpass2" ></span>
                                </div>

                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" v-on:click="updatePassword()">Save changes</button>
                                </div>
                                </div>
                                </div>
                                </div>
      </div>

</div>
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
            drawer: false,
            links: [{ icon: 'arrow_back_ios'}],
            fname: null,
            lname: null,
            email: null,
            password: null,
            password_confirmation: null,
            erroremail: null,
            errorinfo: null,
            errorpass1: null,
            errorpass2: null
        }
    },


  methods: {

    clickDriver: function (driver) {
    return (this.fname = driver.fname, this.lname = driver.lname, this.email = driver.email);
    },

    updateInfo() {
   axios
   .put("/driver/updateinfo", {fname: this.fname, lname: this.lname, email: this.email})
   .then(response => {window.location.reload()})
   .catch(error => {
       console.log()
       this.errorinfo = error.response.data.message;
       });
    },

    updateEmail() {
   axios
   .put("/driver/updateemail", {email: this.email})
   .then(response => {window.location.reload()})
   .catch(error => {
       this.erroremail = error.response.data.errors.email[0];
       });
    },

    updatePassword() {
   axios
   .put("/driver/updatepassword", {password: this.password, password_confirmation: this.password_confirmation})
   .then(response => {window.location.reload()})
   .catch(error => {
       this.errorpass1 = error.response.data.errors.password[0];
       this.errorpass2 = error.response.data.errors.password[1];
       });
    }
  }
}
</script>
