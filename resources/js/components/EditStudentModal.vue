<template>
    <div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="editStudent"
            data-backdrop="static"
            data-keyboard="false"
            tabindex="-1"
            role="dialog"
            aria-labelledby="staticBackdropLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input
                            class="form-control form-control-lg input"
                            type="text"
                            placeholder="First Name"
                            v-model="editingStudent.firstName"
                        />
                        <input
                            class="form-control form-control-lg input"
                            type="text"
                            placeholder="Last Name"
                            v-model="editingStudent.lastName"
                        />
                        <input
                            class="form-control form-control-lg input"
                            type="email"
                            placeholder="Email"
                            v-model="editingStudent.email"
                        />
                        <input
                            class="form-control form-control-lg input"
                            type="password"
                            placeholder="Password"
                            v-model="editingStudent.password"
                        />
                        <input
                            class="form-control form-control-lg input"
                            type="text"
                            placeholder="Index number"
                            v-model="editingStudent.indexNumber"
                        />
                        <input
                            class="form-control form-control-lg input"
                            type="text"
                            placeholder="studyGroup"
                            v-model="editingStudent.studyGroup"
                        />
                        <input
                            class="form-control form-control-lg input"
                            type="text"
                            placeholder="studyYear"
                            v-model="editingStudent.studyYear"
                        />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="editStudent()"
                            :data-dismiss="dismiss"
                        >Add</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- <alert-message :message="alertMsg" :type="msgType" v-show="showMsg"></alert-message> -->
    </div>
</template>

<script>
export default {
    props: {
        student: {
            type: Object,
            required: true
        }
    },
    computed: {
        editingStudent() {
            return this.student;
        }
    },
    data() {
        return {
            dismiss: ""
        };
    },
    methods: {
        editStudent() {
            if (
                this.student.firstName === "" ||
                this.student.lastName === "" ||
                this.student.password === "" ||
                this.teacher.password === undefined ||
                this.student.email === "" ||
                this.student.indexNumber === "" ||
                this.student.studyGroup === "" ||
                this.student.studyYear === ""
            ) {
                console.log("Missing data");
            } else {
                this.dismiss = "modal";
                console.log(this.student);
                axios.post("admin/editstudent", this.student).then(res => {
                    // this.$emit("studentedited", res.data);
                });
            }
        }
    }
};
</script>

<style scoped>
.input {
    margin: 10px 0px;
}
</style>
