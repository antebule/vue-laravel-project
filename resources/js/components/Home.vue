<template>
    <div class="container-fluid">
        <div class="row">
            <sidebar
                role="Student"
                :links="['Dashboard', 'Reservations', 'History', 'Teachers', 'Profile']"
            />
            <div class="col-10">
                <modal />

                <div class="d-flex flex-wrap justify-content-start align-items-start">
                    <div
                        class="card text-center"
                        v-for="thesis in theses"
                        :key="thesis.id"
                        :class="[ status(thesis.status) ? 'border-success': 'border-danger']"
                    >
                        <h4 class="card-header">{{ thesis.title }}</h4>
                        <div class="card-body">
                            <h5
                                class="card-title"
                            >Teacher: {{ thesis.teacher.firstName }} {{ thesis.teacher.lastName }}</h5>
                            <p class="card-text">
                                Status:
                                <b
                                    :class="[ status(thesis.status) ? 'text-success': 'text-danger']"
                                >{{ thesis.status }}</b>
                            </p>
                            <div>
                                <button
                                    class="btn btn-danger"
                                    @click.prevent="thesisCancel(thesis)"
                                >{{ thesis.status === "Approved" || thesis.status === 'Rejected' ? 'Abandon' : 'Cancel' }}</button>
                            </div>
                        </div>
                        <div class="card-footer text-muted">Sent: {{ thesis.created_at | date}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import modal from "./Modal";
import sidebar from "./sidebar";
export default {
    components: {
        sidebar,
        modal
    },
    data() {
        return {
            theses: []
        };
    },
    methods: {
        getCurrentUser() {
            axios.get("user/current").then(res => {
                this.user = res.data;
                this.getThesisRequests(res.data.id);
            });
        },
        getThesisRequests(user_id) {
            axios.post("user/thesisrequests", { id: user_id }).then(res => {
                if (res.data.length) {
                    res.data.forEach(thesis => {
                        this.getTeacherById(thesis.teacher_id, thesis);
                    });
                } else {
                    this.theses.push(res.data);
                    this.getTeacherById(res.data.teacher_id, res.data);
                }
            });
        },
        getTeacherById(teacher_id, thesis) {
            axios.post("thesis/teacher", { id: teacher_id }).then(res => {
                thesis.teacher = res.data;
                this.theses.push(thesis);
            });
        },
        status(thesisStatus) {
            return thesisStatus === "Approved" ? true : false;
        },
        thesisCancel(thesis) {
            console.log("Cances thesis reservation");
        }
    },
    created() {
        this.getCurrentUser();
    },
    filters: {
        date(date) {
            date = date.slice(0, 10);
            return date;
        }
    }
};
</script>

<style scoped>
.row {
    min-height: calc(100vh - 55px);
}

.card {
    width: 250px;
    margin: 10px;
    align-self: stretch;
    max-height: 300px;
}

@media (max-width: 700px) {
    .d-flex {
        flex-direction: row !important;
        justify-content: center !important;
    }

    .col-10 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}

.card-header {
    min-height: 75px;
}
</style>
