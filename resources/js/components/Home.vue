<template>
    <div class="container-fluid">
        <div class="row" id="main">
            <sidebar
                role="Student"
                :links="['Dashboard', 'Reservations', 'History', 'Teachers', 'Profile']"
            />
            <div class="col-10">
                <modal @newthesis="newThesisAdded" />

                <theses :theses="theses" />
            </div>
        </div>
    </div>
</template>

<script>
import modal from "./Modal";
import sidebar from "./sidebar";
import theses from "./Theses";
export default {
    components: {
        sidebar,
        modal,
        theses
    },
    data() {
        return {
            theses: []
        };
    },
    methods: {
        newThesisAdded(newThesis) {
            this.getTeacherById(newThesis.teacher_id, newThesis);
        },
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
        }
    },
    created() {
        this.getCurrentUser();
    }
};
</script>

<style scoped>
.container-fluid {
    overflow-x: hidden;
}

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
