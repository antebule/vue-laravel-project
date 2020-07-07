<template>
    <div>
        <!-- Button trigger modal -->
        <!-- <button
            type="button"
            class="btn btn-success"
            data-toggle="modal"
            data-target="#staticBackdrop"
        >Edit teacher</button>-->

        <!-- Modal -->
        <div
            class="modal fade"
            id="editTeacher"
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
                        <h5 class="modal-title" id="staticBackdropLabel">Edit teacher</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input
                            class="form-control form-control-lg input"
                            type="text"
                            placeholder="First Name"
                            v-model="editingTeacher.firstName"
                        />
                        <input
                            class="form-control form-control-lg input"
                            type="text"
                            placeholder="Last Name"
                            v-model="editingTeacher.lastName"
                        />
                        <input
                            class="form-control form-control-lg input"
                            type="email"
                            placeholder="Email"
                            v-model="editingTeacher.email"
                        />
                        <input
                            class="form-control form-control-lg input"
                            type="password"
                            placeholder="Password"
                            v-model="editingTeacher.password"
                        />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="editTeacher()"
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
        teacher: {
            type: Object,
            required: true
        }
    },
    computed: {
        editingTeacher() {
            return this.teacher;
        }
    },
    data() {
        return {
            dismiss: ""
        };
    },
    methods: {
        editTeacher() {
            if (
                this.teacher.firstName === "" ||
                this.teacher.lastName === "" ||
                this.teacher.password === "" ||
                this.teacher.password === undefined ||
                this.teacher.email === ""
            ) {
                console.log("Missing data");
            } else {
                this.dismiss = "modal";
                axios
                    .post("admin/editteacher", this.teacher)
                    .then(res => {
                        // this.$emit("teacheredited", res.data);
                    })
                    .catch(error => console.log(error));
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
