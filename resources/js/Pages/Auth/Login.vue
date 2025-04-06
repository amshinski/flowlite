<template>
    <Head title="Log in" />

    <div class="relative bg-black w-full h-screen overflow-hidden">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px] object-cover object-center"
            src="https://laravel.com/assets/img/welcome/background.svg" />

        <div class="grid place-content-center w-full h-full">
            <div class="w-80 p-8
                bg-gray-500 rounded-md bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-10 border border-gray-100">
                <Loader v-if="loading" />
                <AuthenticationCardLogo
                    v-if="!loading"
                    class="flex flex-row justify-center mb-8"
                    iconHeight="80px"
                    iconSize="80px" />
                <div v-show="!loading" ref="telegramWidgetContainer" class="flex flex-row justify-center"></div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import { onMounted, ref } from 'vue';
import Loader from '@/Components/Loader.vue';

const loading = ref(true);
const telegramWidgetContainer = ref(null);

const addAuth = () => {
    window.TelegramLoginWidget = function (d, s, id) {
        let js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://telegram.org/js/telegram-widget.js?19";
        fjs.parentNode.insertBefore(js, fjs);
    };
    TelegramLoginWidget(document, "script", "telegram-login-script");

    window.TelegramLoginWidgetAuth = function (user) {
        axios.post('/telegram/auth/callback', user)
            .then(response => {
                if (response.data.success) {
                    window.location.href = response.data.redirect_url;
                } else {
                    alert('Authentication failed.');
                }
            })
            .catch(error => {
                console.error('Error during Telegram authentication:', error);
            });
    };

    const scriptElement = document.createElement('script');
    scriptElement.src = "https://telegram.org/js/telegram-widget.js?19";
    scriptElement.setAttribute('data-telegram-login', 'flowlitebot');
    scriptElement.setAttribute('data-size', 'large');
    scriptElement.setAttribute('data-auth-url', '/telegram/auth/callback');
    scriptElement.setAttribute('data-request-access', 'write');
    telegramWidgetContainer.value.appendChild(scriptElement);
};

onMounted(() => {
    addAuth();

    const timerId = setTimeout(() => {
        loading.value = false;
    }, 1000);
});
</script>
