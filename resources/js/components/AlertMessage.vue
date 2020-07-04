<template>
    <transition name="slide">
        <div
            id="alert"
            class="alert"
            :class="'alert-'+type"
            role="alert"
            style="position:absolute; right: 30px; z-index: 101;"
        >{{ message }}</div>
    </transition>
</template>

<script>
export default {
    props: ["message", "type"]
};
</script>

<style scoped>
/* .slide-enter {
} */

.slide-enter-active {
    animation: slide-in 1s ease-out forwards;
}

/* .slide-leave {
} */

.slide-leave-active {
    animation: slide-out 1s ease-out forwards;
}

@keyframes slide-in {
    from {
        transform: translateX(1000px);
    }
    to {
        transform: translateX(0px);
    }
}

@keyframes slide-out {
    from {
        transform: translateX(0);
    }
    to {
        transform: translateX(1000px);
    }
}
</style>