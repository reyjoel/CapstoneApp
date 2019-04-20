<template>
  <v-layout>
    <v-toolbar color="white" flat fixed>
      <v-btn style="text-decoration:none;" href="/admin/home" icon light>
        <v-icon color="grey darken-2">arrow_back</v-icon>
      </v-btn>
    </v-toolbar>


    <div class="mt-5 container">
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#add">Add New Student</button>

                    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add New Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">

                    <input class="mb-3 form-control" type="text" placeholder="Student ID" v-model="add_stu_id">
                    <input class="mb-3 form-control" type="text" placeholder="Bus ID" v-model="add_bus_id">
                    <input class="mb-3 form-control" type="text" placeholder="First Name" v-model="add_fname">
                    <input class="mb-3 form-control" type="text" placeholder="Last Name" v-model="add_lname">
                    <input class="mb-3 form-control" type="email" placeholder="Email Address" v-model="add_email">
                    <input class="mb-3 form-control" type="password" placeholder="Password" v-model="add_password">

                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" v-on:click="addStudent()">Save changes</button>
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
                  <th scope="col">Student ID</th>
                  <th scope="col">Bus ID</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Email Address</th>
                  <th scope="col">Created At</th>
                  <th scope="col">Updated At</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody v-for="student in students" :key="student.id">
                <tr>
                  <th scope="row">{{ student.stu_id }}</th>
                  <td>{{ student.bus_id }}</td>
                  <td>{{ student.fname }}</td>
                  <td>{{ student.lname }}</td>
                  <td>{{ student.email }}</td>
                  <td>{{ student.created_at }}</td>
                  <td>{{ student.updated_at }}</td>
                  <td>
                    <button v-on:click="clickStudent(student)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#update">Update</button>


                                <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Update Student No.: {{stu_id}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">

                                <input class="mb-3 form-control" type="text" placeholder="Student ID" v-model="stu_id">
                                <input class="mb-3 form-control" type="text" placeholder="Bus ID" v-model="bus_id">
                                <input class="mb-3 form-control" type="text" placeholder="First Name" v-model="fname">
                                <input class="mb-3 form-control" type="text" placeholder="Last Name" v-model="lname">
                                <input class="mb-3 form-control" type="email" placeholder="Email Address" v-model="email">
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" v-on:click="updateStudent()">Save changes</button>
                                </div>
                                </div>
                                </div>
                                </div>

                    <button v-on:click="clickStudent(student)" type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">Delete</button>

                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Delete Student No.: {{stu_id}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                Are you sure?
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" v-on:click="deleteStudent()">Delete Student</button>
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
        students: [],
        stu_id: null,
        bus_id: null,
        fname: null,
        lname: null,
        email: null,
        add_stu_id: null,
        add_bus_id: null,
        add_fname: null,
        add_lname: null,
        add_email: null,
        add_password: null
    };
  },

  created() {

    this.fetchStudents();

  },

  methods: {

    fetchStudents() {
      axios.get("/admin/showstutable").then(response => {
        this.students = response.data.students;

      });
    },

    addStudent() {
    axios.post("/admin/addstudent", {add_stu_id: this.add_stu_id, add_bus_id: this.add_bus_id, add_fname: this.add_fname, add_lname: this.add_lname, add_email: this.add_email, add_password: this.add_password}).then(response => {});
       window.location.reload()
    },

    clickStudent: function (student) {
    return (this.stu_id = student.stu_id, this.bus_id = student.bus_id, this.fname = student.fname, this.lname = student.lname, this.email = student.email);
    },

    updateStudent () {
   axios.put("/admin/updatestudent", {stu_id: this.stu_id, bus_id: this.bus_id, fname: this.fname, lname: this.lname, email: this.email}).then(response => {});
    window.location.reload()
    },

    deleteStudent () {
    axios.post("/admin/deletestudent", {stu_id: this.stu_id}).then(response => {});
       window.location.reload()
    }

  }
};
</script>
