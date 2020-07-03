<template>
    <div class="container-fluid">
        <div class="row">
            <sidebar
                role="Teacher"
                :links="['Dashboard', 'Reservations', 'History', 'Students', 'Profile']"
            />
            <div class="d-flex flex-wrap justify-content-start align-items-start col-10">
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
                        >Student: {{ thesis.student.firstName }} {{ thesis.student.lastName }}</h5>
                        <p class="card-text">
                            Status:
                            <b
                                :class="[ status(thesis.status) ? 'text-success': 'text-danger']"
                            >{{ thesis.status }}</b>
                        </p>
                        <div v-if="thesis.status !== 'Rejected' && thesis.status !== 'Approved'">
                            <button
                                class="btn btn-primary"
                                @click.prevent="thesisAccepted(thesis)"
                            >Accept</button>
                            <button
                                class="btn btn-danger"
                                @click.prevent="thesisRejected(thesis)"
                            >Reject</button>
                        </div>
                    </div>
                    <div class="card-footer text-muted">Sent: {{ thesis.created_at | date }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import sidebar from "./sidebar.vue";
export default {
    components: {
        sidebar
    },
    data() {
        return {
            theses: []
        };
    },
    methods: {
        getThesisRequests(teacher_id) {
            axios
                .post("teacher/thesisrequests", { id: teacher_id })
                .then(res => {
                    if (res.data.length) {
                        res.data.forEach(thesis => {
                            this.getStudentById(thesis.user_id, thesis);
                        });
                    } else {
                        this.theses.push(res.data);
                        this.getStudentById(res.data.user_id, res.data);
                    }
                });
        },
        getStudentById(student_id, thesis) {
            axios.post("thesis/student", { id: student_id }).then(res => {
                thesis.student = res.data;
                this.theses.push(thesis);
            });
        },
        getCurrentTeacher() {
            axios.get("teacher/current").then(res => {
                this.teacher = res.data;
                this.getThesisRequests(res.data.id);
            });
        },
        thesisAccepted(thesis) {
            thesis.status = "Approved";
            axios.post("teacher/thesisresponse", thesis).then(res => {});
        },
        thesisRejected(thesis) {
            thesis.status = "Rejected";
            axios.post("teacher/thesisresponse", thesis).then(res => {});
        },
        status(thesisStatus) {
            return thesisStatus === "Approved" ? true : false;
        }
    },
    created() {
        this.getCurrentTeacher();
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