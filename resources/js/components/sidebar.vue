<template>
    <div style="background-color: white;" class="col-md-2 col-lg-2 p-md-4 p-lg-5">
        <nav
            id="navbarSupportedContent"
            class="d-md-block bg-white sidebar collapse navbar-collapse"
        >
            <div class="sidebar-sticky ml-30">
                <h1 style="margin-left: 30px;">
                    <i class="fa fa-user"></i>
                </h1>
                <h3>{{this.role}}</h3>
                <ul class="nav flex-column">
                    <li class="nav-item" v-for="(item, index) in this.links" :key="index">{{item}}</li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    props: {
        role: {
            type: String,
            required: true
        },
        links: {
            type: Array
        }
    }
};
</script>

<style scoped>
/* #navbarSupportedContent {
    padding-right: 50px;
    height: calc(100vh - 55px);
} */

/* @media (max-width: 700px) {
    .d-flex {
        flex-direction: row;
    }
} */
</style>