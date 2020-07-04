<template>
    <div class="d-flex flex-wrap justify-content-center align-items-start">
        <div
            class="card text-center"
            v-for="thesis in theses"
            :key="thesis.id"
            :class="[ {'border-success' : status(thesis.status)}, {'border-danger' : rejestedStatus(thesis.status)} , {'border-warning' : awaiting(thesis.status)} ]"
        >
            <h4 class="card-header">{{ thesis.title }}</h4>
            <div class="card-body">
                <h5
                    v-if="thesis.teacher"
                    class="card-title"
                >Teacher: {{ thesis.teacher.firstName }} {{ thesis.teacher.lastName }}</h5>
                <h5
                    v-else
                    class="card-title"
                >Student: {{ thesis.student.firstName }} {{ thesis.student.lastName }}</h5>
                <p class="card-text">
                    Status:
                    <b
                        :class="[ {'text-success' : status(thesis.status)}, {'text-danger' : rejestedStatus(thesis.status)} , {'text-warning' : awaiting(thesis.status)} ]"
                    >{{ thesis.status }}</b>
                </p>
                <div v-if="thesis.teacher">
                    <button
                        class="btn btn-danger"
                        @click.prevent="thesisCancel(thesis)"
                    >{{ thesis.status === "Approved" || thesis.status === 'Rejected' ? 'Abandon' : 'Cancel' }}</button>
                </div>
                <div
                    v-else-if="thesis.status !== 'Rejected' && thesis.status !== 'Approved' && thesis.student"
                >
                    <button class="btn btn-primary" @click.prevent="thesisAccepted(thesis)">Accept</button>
                    <button class="btn btn-danger" @click.prevent="thesisRejected(thesis)">Reject</button>
                </div>
            </div>
            <div class="card-footer text-muted">Sent: {{ thesis.created_at | date}}</div>
        </div>

        <alert-message :message="alertMsg" :type="alertType" v-if="showMsg"></alert-message>
    </div>
</template>

<script>
import alertMessage from "./AlertMessage";
export default {
    components: {
        "alert-message": alertMessage
    },
    props: {
        theses: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            alertMsg: "",
            alertType: "",
            showMsg: false
        };
    },
    methods: {
        status(thesisStatus) {
            return thesisStatus === "Approved" ? true : false;
        },
        rejestedStatus(thesisStatus) {
            return thesisStatus === "Rejected" ? true : false;
        },
        awaiting(thesisStatus) {
            return thesisStatus !== "Approved" && thesisStatus !== "Rejected"
                ? true
                : false;
        },
        thesisCancel(thesis) {
            axios.post("thesis/delete", thesis).then(() => {
                this.alertMsg = thesis.title + " Successfully Removed!";
                this.alertType = "success";
                this.showMsg = true;
                setTimeout(() => {
                    this.showMsg = false;
                }, 3000);
                const index = this.theses.indexOf(thesis);
                if (index !== -1) {
                    this.theses.splice(index, 1);
                }
            });
        },
        thesisAccepted(thesis) {
            thesis.status = "Approved";
            axios.post("teacher/thesisresponse", thesis).then(res => {});
        },
        thesisRejected(thesis) {
            thesis.status = "Rejected";
            axios.post("teacher/thesisresponse", thesis).then(res => {});
        }
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
.card {
    width: 250px;
    margin: 10px;
    align-self: stretch;
    max-height: 300px;
}

.card-header {
    min-height: 75px;
}
</style>