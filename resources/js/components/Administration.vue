<template>
    <div class="container-fluid">
        <div class="row" id="main">
            <sidebar
                role="Admin"
                :links="['Administration', 'Reservations', 'History', 'Profile']"
            />
            <div class="col-10">
                <div class="container">
                    <div id="students">
                        <h2 style="text-align: center;">Students</h2>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="student in students" :key="student.id">
                                    <th scope="row">{{student.id}}</th>
                                    <td>{{student.firstName}} {{student.lastName}}</td>
                                    <td>{{student.email}}</td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <p
                                            class="action text-primary"
                                            @click="studentEdit(student)"
                                            data-toggle="modal"
                                            data-target="#editStudent"
                                        >Edit</p>
                                        <edit-student-modal :student="editingStudent" />
                                        <p
                                            class="action text-danger"
                                            @click="studentDelete(student)"
                                        >Delete</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <add-student-modal @studentadded="getStudents()" />
                    </div>

                    <div id="teachers">
                        <h2 style="text-align: center;">Teachers</h2>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="teacher in teachers" :key="teacher.id">
                                    <th scope="row">{{teacher.id}}</th>
                                    <td>{{teacher.firstName}} {{teacher.lastName}}</td>
                                    <td>{{teacher.email}}</td>
                                    <td>
                                        <p
                                            class="action text-primary"
                                            @click="teacherEdit(teacher)"
                                            data-toggle="modal"
                                            data-target="#editTeacher"
                                        >Edit</p>
                                        <edit-teacher-modal :teacher="editingTeacher" />
                                        <p
                                            class="action text-danger"
                                            @click="teacherDelete(teacher)"
                                        >Delete</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <add-teacher-modal @teacheradded="getTeachers()" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import sidebar from "./sidebar";
import newStudentModal from "./AddStudentModal";
import newTeacherModal from "./AddTeacherModal";
import editStudentModal from "./EditStudentModal";
import editTeacherModal from "./EditTeacherModal";
export default {
    components: {
        sidebar,
        "add-student-modal": newStudentModal,
        "add-teacher-modal": newTeacherModal,
        "edit-student-modal": editStudentModal,
        "edit-teacher-modal": editTeacherModal
    },
    computed: {
        editingStudent() {
            return this.editStudent;
        },
        editingTeacher() {
            return this.editTeacher;
        }
    },
    data() {
        return {
            students: [],
            teachers: [],
            editStudent: {},
            editTeacher: {}
        };
    },
    created() {
        this.getStudents();
        this.getTeachers();
    },
    methods: {
        getStudents() {
            axios.get("user/all").then(res => {
                if (res.data.length) {
                    this.students = res.data;
                } else {
                    this.students.push(res.data);
                }
            });
        },
        getTeachers() {
            axios.get("teacher/all").then(res => {
                if (res.data.length) {
                    this.teachers = res.data;
                } else {
                    this.teachers.push(res.data);
                }
            });
        },
        teacherEdit(teacher) {
            this.editTeacher = teacher;
        },
        teacherDelete(teacher) {
            axios.post("admin/deleteTeacher", teacher).then(res => {
                const index = this.teachers.indexOf(teacher);
                if (index !== -1) {
                    this.teachers.splice(index, 1);
                }
            });
        },
        studentEdit(student) {
            this.editStudent = student;
        },
        studentDelete(student) {
            axios.post("admin/deleteStudent", student).then(res => {
                const index = this.students.indexOf(student);
                if (index !== -1) {
                    this.students.splice(index, 1);
                }
            });
        }
    }
};
</script>

<style scoped>
.row {
    min-height: calc(100vh - 55px);
    justify-content: center;
}

.action:hover {
    cursor: pointer;
}

#students {
    margin-top: 10px;
}

@media (max-width: 767px) {
    .d-flex {
        flex-direction: row !important;
    }

    #main {
        display: block;
    }

    .col-10 {
        flex: 0 0 100%;
        max-width: 100%;
        padding-left: 0;
    }
}
</style>