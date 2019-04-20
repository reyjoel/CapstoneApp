<template>
  <v-layout>
    <v-toolbar color="white" flat fixed>
      <v-btn style="text-decoration:none;" href="/admin/home" icon light>
        <v-icon color="grey darken-2">arrow_back</v-icon>
      </v-btn>
    </v-toolbar>


    <div class="mt-5 container">
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#add">Add New Driver</button>

                    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add New Driver</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">

                    <input class="mb-3 form-control" type="text" placeholder="License Number" v-model="add_lic_num">
                    <input class="mb-3 form-control" type="text" placeholder="Bus ID" v-model="add_bus_id">
                    <input class="mb-3 form-control" type="text" placeholder="First Name" v-model="add_fname">
                    <input class="mb-3 form-control" type="text" placeholder="Last Name" v-model="add_lname">
                    <input class="mb-3 form-control" type="email" placeholder="Email Address" v-model="add_email">
                    <input class="mb-3 form-control" type="password" placeholder="Password" v-model="add_password">

                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" v-on:click="addDriver()">Save changes</button>
                    </div>
                    </div>
                    </div>
                    </div>

      <div class="row justify-content-center">
        <div class="col-sm">
          <div class="card">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Driver ID</th>
                  <th scope="col">License Number</th>
                  <th scope="col">Bus ID</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Email Address</th>
                  <th scope="col">Created At</th>
                  <th scope="col">Updated At</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody v-for="driver in drivers" :key="driver.id">
                <tr>
                  <th scope="row">{{ driver.id }}</th>
                  <td>{{ driver.lic_num }}</td>
                  <td>{{ driver.bus_id }}</td>
                  <td>{{ driver.fname }}</td>
                  <td>{{ driver.lname }}</td>
                  <td>{{ driver.email }}</td>
                  <td>{{ driver.created_at }}</td>
                  <td>{{ driver.updated_at }}</td>
                  <td>
                    <button v-on:click="clickDriver(driver)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#update">Update</button>


                                <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Update Driver No.: {{fname}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">

                                <input class="mb-3 form-control" type="text" placeholder="Driver ID" v-model="lic_num">
                                <input class="mb-3 form-control" type="text" placeholder="Bus ID" v-model="bus_id">
                                <input class="mb-3 form-control" type="text" placeholder="First Name" v-model="fname">
                                <input class="mb-3 form-control" type="text" placeholder="Last Name" v-model="lname">
                                <input class="mb-3 form-control" type="email" placeholder="Email Address" v-model="email">
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" v-on:click="updateDriver()">Save changes</button>
                                </div>
                                </div>
                                </div>
                                </div>

                    <button v-on:click="clickDriver(driver)" type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">Delete</button>

                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Delete Driver No.: {{fname}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                Are you sure?
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" v-on:click="deleteDriver()">Delete Driver</button>
                                </div>
                                </div>
                                </div>
                                </div>

                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </v-layout>
</template>

<script>
export default {
  props: {
    admin: {
      type: Object,
      required: true
    }
  },

  data() {
    return {
        drivers: [],
        lic_num: null,
        bus_id: null,
        fname: null,
        lname: null,
        email: null,
        add_lic_num: null,
        add_bus_id: null,
        add_fname: null,
        add_lname: null,
        add_email: null,
        add_password: null
    };
  },

  created() {
    this.fetchDrivers();

  },

  methods: {

    fetchDrivers() {
      axios.get("/admin/showdritable").then(response => {
        this.drivers = response.data.drivers;

      });
    },

    addDriver() {
    axios.post("/admin/adddriver", {add_lic_num: this.add_lic_num, add_bus_id: this.add_bus_id, add_fname: this.add_fname, add_lname: this.add_lname, add_email: this.add_email, add_password: this.add_password}).then(response => {});
       window.location.reload()
    },

    clickDriver: function (driver) {
    return (this.lic_num = driver.lic_num, this.bus_id = driver.bus_id, this.fname = driver.fname, this.lname = driver.lname, this.email = driver.email);
    },

    updateDriver () {
   axios.put("/admin/updatedriver", {lic_num: this.lic_num, bus_id: this.bus_id, fname: this.fname, lname: this.lname, email: this.email}).then(response => {});
    window.location.reload()
    },

    deleteDriver () {
    axios.post("/admin/deletedriver", {lic_num: this.lic_num}).then(response => {});
       window.location.reload()
    }

  }
};
</script>
