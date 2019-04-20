<template>
  <v-layout>
    <v-toolbar color="white" flat fixed>
      <v-btn style="text-decoration:none;" href="/admin/home" icon light>
        <v-icon color="grey darken-2">arrow_back</v-icon>
      </v-btn>
    </v-toolbar>


    <div class="mt-5 container">
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#add">Add New Bus</button>

                    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add New Bus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">

                    <input class="mb-3 form-control" type="text" placeholder="Plate Number" v-model="add_plate_num">
                    <input class="mb-3 form-control" type="text" placeholder="Registration Number" v-model="add_reg_num">

                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" v-on:click="addBus()">Save changes</button>
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
                  <th scope="col">Bus ID</th>
                  <th scope="col">Plate Number</th>
                  <th scope="col">Registration Number</th>
                  <th scope="col">Created At</th>
                  <th scope="col">Updated At</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody v-for="bus in buses" :key="bus.id">
                <tr>
                  <th scope="row">{{ bus.id }}</th>
                  <td>{{ bus.plate_num }}</td>
                  <td>{{ bus.reg_num }}</td>
                  <td>{{ bus.created_at }}</td>
                  <td>{{ bus.updated_at }}</td>
                  <td>
                    <button v-on:click="clickBus(bus)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#update">Update</button>


                                <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Update Bus Plate No.: {{plate_num}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">

                                <input class="mb-3 form-control" type="text" placeholder="Plate Number" v-model="plate_num">
                                <input class="mb-3 form-control" type="text" placeholder="Registration Number" v-model="reg_num">
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" v-on:click="updateBus()">Save changes</button>
                                </div>
                                </div>
                                </div>
                                </div>

                    <button v-on:click="clickBus(bus)" type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">Delete</button>

                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Delete Bus Plate No.: {{plate_num}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                Are you sure?
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" v-on:click="deleteBus()">Delete Bus</button>
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
        buses: [],
        plate_num: null,
        reg_num: null,
        add_plate_num: null,
        add_reg_num: null
    };
  },

  created() {
    this.fetchBuses();

  },

  methods: {

    fetchBuses() {
      axios.get("/admin/showbustable").then(response => {
        this.buses = response.data.buses;

      });
    },

    addBus() {
    axios.post("/admin/addbus", {add_plate_num: this.add_plate_num, add_reg_num: this.add_reg_num}).then(response => {});
       window.location.reload()
    },

    clickBus: function (bus) {
    return (this.plate_num = bus.plate_num, this.reg_num = bus.reg_num);
    },

    updateBus () {
   axios.put("/admin/updatebus", {plate_num: this.plate_num, reg_num: this.reg_num}).then(response => {});
    window.location.reload()
    },

    deleteBus () {
    axios.post("/admin/deletebus", {plate_num: this.plate_num}).then(response => {});
       window.location.reload()
    }

  }
};
</script>
