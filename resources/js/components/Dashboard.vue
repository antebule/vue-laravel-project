<template>
    <div class="container-fluid">
        <div class="row" id="main">
            <sidebar
                role="Teacher"
                :links="['Dashboard', 'Reservations', 'History', 'Students', 'Profile']"
            />
            <div class="col-10">
                <theses :theses="theses" />
            </div>
        </div>
    </div>
</template>

<script>
import theses from "./Theses";
import sidebar from "./sidebar";
export default {
    components: {
        sidebar,
        theses
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
        }
    },
    created() {
        this.getCurrentTeacher();
    }
};
</script>

<style scoped>
.row {
    min-height: calc(100vh - 55px);
    justify-content: center;
}

@media (max-width: 767px) {
    .d-flex {
        flex-direction: row !important;
        /* justify-content: center !important; */
    }

    #main {
        display: block;
    }

    .col-10 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}
</style>