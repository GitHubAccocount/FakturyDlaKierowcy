import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";

const appName = import.meta.env.VITE_APP_NAME || "Faktura";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});

/** Solution to problem with 'back' button in a browser which
 * clicking was causing displaying previously visited pages.
 * Soluation posted on github: "https://github.com/inertiajs/inertia/issues/247"
 * by Abdulhakimsg
 */
window.addEventListener("popstate", async (e) => {
    e.stopImmediatePropagation();
    try {
        // to check if application session is still valid
        const res = await fetch("/dashboard/state");
        if (res.ok) {
            window.location.replace(e.state.url);
        }
    } catch (e) {
        window.location.replace("/login");
    }
});
