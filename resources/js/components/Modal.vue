<template>
    <div>
        <!-- Button trigger modal -->
        <button
            type="button"
            class="btn btn-primary"
            data-toggle="modal"
            data-target="#staticBackdrop"
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

        <!-- Alert messages -->
        <div
            id="alert"
            class="alert alert-success"
            role="alert"
            v-show="success"
            style="position:absolute; right: 0px;"
        >A simple success alert—check it out!</div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            title: "",
            selected: "Choose...",
            teachers: [],
            dismiss: "",
            success: false
        };
    },
    methods: {
        getTeachers() {
            axios.get("teacher/all").then(data => {
                this.teachers = data.data;
            });
        },
        createThesisReservation() {
            axios
                .post("thesis/create", {
                    title: this.title,
                    status: "Awaiting teacher approval",
                    user_id: this.userID,
                    teacher_id: this.selected.id
                })
                .then(() => {
                    this.title = "";
                    this.selected = "Choose...";
                    this.dismiss = "";
                    this.success = true;
                });
        },
        submit() {
            if (this.title !== "" && this.selected !== "Choose...") {
                this.createThesisReservation();
                this.dismiss = "modal";
            } else {
                console.log("Input data error!!!");
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

.slide-left {
    -webkit-animation: slide-left 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)
        forwards;
    animation: slide-left 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
}

.slide-left {
    animation: fade-out 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
}

@-webkit-keyframes slide-left {
    0% {
        -webkit-transform: translateX(0);
        transform: translateX(100px);
    }
    100% {
        -webkit-transform: translateX(-100px);
        transform: translateX(0px);
    }
}
@keyframes slide-left {
    0% {
        -webkit-transform: translateX(0);
        transform: translateX(100px);
    }
    100% {
        -webkit-transform: translateX(-100px);
        transform: translateX(0px);
    }
}

.slide-out-right {
    -webkit-animation: slide-out-right 0.8s
        cubic-bezier(0.55, 0.085, 0.68, 0.53) 2.8s backwards;
    animation: slide-out-right 0.8s cubic-bezier(0.55, 0.085, 0.68, 0.53) 2.8s
        backwards;
}

@-webkit-keyframes slide-out-right {
    0% {
        -webkit-transform: translateX(0);
        transform: translateX(0);
        opacity: 1;
    }
    100% {
        -webkit-transform: translateX(1000px);
        transform: translateX(1000px);
        opacity: 0;
    }
}
@keyframes slide-out-right {
    0% {
        -webkit-transform: translateX(0);
        transform: translateX(0);
        opacity: 1;
    }
    100% {
        -webkit-transform: translateX(1000px);
        transform: translateX(1000px);
        opacity: 0;
    }
}
</style>