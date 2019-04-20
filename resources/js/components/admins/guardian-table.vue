<template>
  <v-layout>
    <v-toolbar color="white" flat fixed>
      <v-btn style="text-decoration:none;" href="/admin/home" icon light>
        <v-icon color="grey darken-2">arrow_back</v-icon>
      </v-btn>
    </v-toolbar>


    <div class="mt-5 container">
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#add">Add New Guaridan</button>

                    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add New Guardian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">

                    <input class="mb-3 form-control" type="text" placeholder="Student ID" v-model="add_student_id">
                    <input class="mb-3 form-control" type="text" placeholder="First Name" v-model="add_fname">
                    <input class="mb-3 form-control" type="text" placeholder="Last Name" v-model="add_lname">
                    <input class="mb-3 form-control" type="email" placeholder="Email Address" v-model="add_email">
                    <input class="mb-3 form-control" type="password" placeholder="Password" v-model="add_password">

                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" v-on:click="addGuardian()">Save changes</button>
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
                  <th scope="col">Guardian ID</th>
                  <th scope="col">Student ID</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Email Address</th>
                  <th scope="col">Created At</th>
                  <th scope="col">Updated At</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody v-for="guardian in guardians" :key="guardian.id">
                <tr>
                  <th scope="row">{{ guardian.id }}</th>
                  <td>{{ guardian.student_id }}</td>
                  <td>{{ guardian.fname }}</td>
                  <td>{{ guardian.lname }}</td>
                  <td>{{ guardian.email }}</td>
                  <td>{{ guardian.created_at }}</td>
                  <td>{{ guardian.updated_at }}</td>
                  <td>
                    <button v-on:click="clickGuardian(guardian)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#update">Update</button>


                                <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Update Guardian No.: {{fname}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">

                                <input class="mb-3 form-control" type="text" placeholder="Guardian ID" v-model="student_id">
                                <input class="mb-3 form-control" type="text" placeholder="First Name" v-model="fname">
                                <input class="mb-3 form-control" type="text" placeholder="Last Name" v-model="lname">
                                <input class="mb-3 form-control" type="email" placeholder="Email Address" v-model="email">
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" v-on:click="updateGuardian()">Save changes</button>
                                </div>
                                </div>
                                </div>
                                </div>

                    <button v-on:click="clickGuardian(guardian)" type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">Delete</button>

                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Delete Guardian No.: {{fname}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                Are you sure?
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" v-on:click="deleteGuardian()">Delete Guardian</button>
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
        guardians: [],
        student_id: null,
        fname: null,
        lname: null,
        email: null,
        add_student_id: null,
        add_fname: null,
        add_lname: null,
        add_email: null,
        add_password: null
    };
  },

  created() {
    this.fetchGuardians();

  },

  methods: {

    fetchGuardians() {
      axios.get("/admin/showguatable").then(response => {
        this.guardians = response.data.guardians;

      });
    },

    addGuardian() {
    axios.post("/admin/addguardian", {add_student_id: this.add_student_id, add_fname: this.add_fname, add_lname: this.add_lname, add_email: this.add_email, add_password: this.add_password}).then(response => {});
       window.location.reload()
    },

    clickGuardian: function (guardian) {
    return (this.student_id = guardian.student_id, this.fname = guardian.fname, this.lname = guardian.lname, this.email = guardian.email);
    },

    updateGuardian () {
   axios.put("/admin/updateguardian", {student_id: this.student_id, fname: this.fname, lname: this.lname, email: this.email}).then(response => {});
    window.location.reload()
    },

    deleteGuardian () {
    axios.post("/admin/deleteguardian", {student_id: this.student_id}).then(response => {});
       window.location.reload()
    }

  }
};
</script>
