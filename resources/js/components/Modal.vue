<template>
    <div style="text-align:center;">
        <!-- Button trigger modal -->
        <button
            type="button"
            class="btn btn-primary"
            data-toggle="modal"
            data-target="#staticBackdrop"
            style="margin: 20px 0px 10px 0px;"
        >Reserve Thesis</button>

        <!-- Modal -->
        <div
            class="modal fade"
            id="staticBackdrop"
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
                        <h5 class="modal-title" id="staticBackdropLabel">Thesis Reservation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input
                            class="form-control form-control-lg"
                            type="text"
                            placeholder="Title..."
                            v-model="title"
                        />
                        <div class="form-group md-4 mt-2">
                            <label for="inputState" class="ml-2 mr-2">Teacher</label>
                            <select id="inputState" class="form-control" v-model="selected">
                                <option selected>Choose...</option>
                                <option
                                    v-for="teacher in teachers"
                                    :key="teacher.id"
                                    :value="teacher"
                                >{{teacher.firstName + " " + teacher.lastName}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="submit"
                            :data-dismiss="dismiss"
                        >Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <alert-message :message="alertMsg" :type="msgType" v-show="showMsg"></alert-message>
    </div>
</template>

<script>
import alertMessage from "./AlertMessage";
export default {
    components: {
        "alert-message": alertMessage
    },
    data() {
        return {
            title: "",
            selected: "Choose...",
            teachers: [],
            dismiss: "",
            showMsg: false,
            alertMsg: "",
            msgType: ""
        };
    },
    methods: {
        getTeachers() {
            axios.get("teacher/all").then(data => {
                this.teachers = data.data;
            });
        },
        createThesisReservation() {
            const newThesis = {
                title: this.title,
                status: "Awaiting teacher approval",
                user_id: this.userID,
                teacher_id: this.selected.id
            };
            axios.post("thesis/create", newThesis).then(res => {
                this.alertMsg = this.title + " Thesis Successfully Reserved!";
                this.msgType = "success";
                this.title = "";
                this.selected = "Choose...";
                this.dismiss = "";
                this.showMsg = true;
                setTimeout(() => {
                    this.showMsg = false;
                }, 3000);
                this.$emit("newthesis", res.data);
            });
        },
        submit() {
            if (this.title !== "" && this.selected !== "Choose...") {
                this.createThesisReservation();
                this.dismiss = "modal";
            } else {
                // Missing data alert
                this.alertMsg = "Missing data!";
                this.msgType = "danger";
                this.showMsg = true;
                setTimeout(() => {
                    this.showMsg = false;
                }, 3000);
            }
        }
    },
    created() {
        this.getTeachers();
        axios.get("user/current").then(res => {
            this.userID = res.data.id;
        });
    }
};
</script>

<style scoped>
#inputState {
    display: inline-block;
    width: 35%;
}
</style>