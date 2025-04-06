<script setup>

</script>

<template>
    <div class='loader loader4'>
        <div>
            <div>
                <div>
                    <div>
                        <div>
                            <div>
                                <div>
                                    <div>
                                        <div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
$grey: rgb(0, 197, 24);
$blue: rgb(255, 99, 9);

@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }
    50% {
        transform: rotate(180deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

@keyframes rotate2 {
    0% {
        transform: rotate(0deg);
        border-top-color: $grey;
    }
    50% {
        transform: rotate(180deg);
        border-top-color: $blue;
    }
    100% {
        transform: rotate(360deg);
        border-top-color: $grey;
    }
}

* {
    box-sizing: border-box;
}

@mixin loaderDivMixin {
    border-radius: 50%;
    border: 2px solid transparent;
    animation: rotate linear 3.5s infinite;
}

.loader {
    position: relative;
    margin-left: auto;
    margin-right: auto;
    width: 134px;
    height: 134px;
    display: block;
    overflow: hidden;
    div {
        height: 100%;
    }
}

.loader4, .loader4 div {
    @include loaderDivMixin;
    border-radius: 50%;
    padding: 4px;
    animation: rotate2 4s infinite linear;
}

div:hover {
    animation-play-state: paused;
}

.loader, .loader * {
    will-change: transform;
}

</style>
