<template>
    <div>
        <!-- Button trigger modal -->
        <button
            type="button"
            class="btn btn-success"
            data-toggle="modal"
            data-target="#staticBackdrop"
        >Add teacher</button>

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
                        <h5 class="modal-title" id="staticBackdropLabel">New teacher</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input
                            class="form-control form-control-lg input"
                            type="text"
                            placeholder="First Name"
                            v-model="firstName"
                        />
                        <input
                            class="form-control form-control-lg input"
                            type="text"
                            placeholder="Last Name"
                            v-model="lastName"
                        />
                        <input
                            class="form-control form-control-lg input"
                            type="email"
                            placeholder="Email"
                            v-model="email"
                        />
                        <input
                            class="form-control form-control-lg input"
                            type="password"
                            placeholder="Password"
                            v-model="password"
                        />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="addTeacher()"
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
    data() {
        return {
            firstName: "",
            lastName: "",
            email: "",
            password: "",
            dismiss: ""
        };
    },
    methods: {
        addTeacher() {
            if (
                this.firstName === "" ||
                this.lastName === "" ||
                this.password === "" ||
                this.email === ""
            ) {
                console.log("Missing data");
            } else {
                this.dismiss = "modal";
                const newUser = {
                    firstName: this.firstName,
                    lastName: this.lastName,
                    email: this.email,
                    password: this.password
                };
                axios.post("admin/addteacher", newUser).then(res => {
                    this.$emit("teacheradded", res.data);
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
