<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <svg viewBox="0 0 192 192" xmlns="http://www.w3.org/2000/svg" :class="className" v-bind="$attrs">

        <g fill="none">

            <path
                d="M123.635 123.51a26.613 26.613 0 0 1 5.67 32.783 26.613 26.613 0 0 1-30.752 12.698 26.613 26.613 0 0 1-19.112-27.232 26.613 26.613 0 0 1 22.396-24.603m-22.985-2.902a24.352 24.352 0 0 1-11.313-29.342A24.352 24.352 0 0 1 94.594 68.88a24.352 24.352 0 0 1 20.305 24.014m-46.226 37.375s-7.072 1.52-12.14 4.607"
                style="fill:#88181a;fill-opacity:0;stroke:#88181a;stroke-width:12;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" />

            <path
                d="M102.055 116.96s29.149-7.399 29.888-34.098c0 0 1.283-12.926-10.277-22.154L103.89 45.095s-7.13-9.83 8.914-15.86"
                style="fill:#88181a;fill-opacity:0;stroke:#88181a;stroke-width:12;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" />

            <path
                d="M102.125 49.824h-8.767l6.095-3.519m-1.385-4.281H86.69l11.85-6.978m.276-1.213s-3.664-4.164-6.96-4.133c0 0 4.075-2.934 10.448-.78m3.441-3.033L99 21.717l10.096 2.625"
                style="fill:#88181a;fill-opacity:0;stroke:#88181a;stroke-width:2.06751;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" />

            <path
                d="m111.475 23.77-14.102-6.805 18.942 7.35s4.565 5.607 8.43 5.607h14.208s3.037.22 3.037 3.037h-14.912s-1.07 1.1 0 2.17h12.407l-3.045 3.713s-2.076 1.752-3.828 0h-24.284"
                style="fill:#88181a;fill-opacity:0;stroke:#88181a;stroke-width:2.06751;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" />

            <path d="M116.193 30.078h8.33l-3.91 4.17z"
                  style="fill:#88181a;fill-opacity:0;stroke:#88181a;stroke-width:2.06751;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" />

            <path
                d="M90.577 40.969c.03-.03 6.48-3.825 6.486-3.817.003.004-.016.144-.043.31-.1.621-.164 1.488-.184 2.493l-.02 1.033h-3.13c-1.72 0-3.12-.009-3.109-.02zm7.759-9.101c-.998-.902-1.903-1.573-2.874-2.129l-.428-.246.491-.094c.874-.169 1.082-.186 2.218-.184 1.122.003 1.37.024 2.317.2l.426.079-.345.453a16.504 16.504 0 0 0-1.194 1.81c-.129.232-.242.42-.252.42a5.13 5.13 0 0 1-.36-.309zm35.783 6.675c-.208-.044-.45-.18-.706-.398a2.632 2.632 0 0 0-.36-.26l-.147-.079-11.536-.018-11.536-.018.16-.215c.087-.12.293-.342.456-.496.76-.713 1.88-1.251 3.544-1.702 1.155-.313 1.722-.563 2.465-1.089a7.77 7.77 0 0 0 1.152-1.07l.158-.187 1.097 1.04c1.242 1.178 1.322 1.235 1.742 1.237.492.002.407.076 2.592-2.258l1.94-2.072 6.957.009 6.957.008.323.1c.43.136.778.324 1.032.559.115.106.21.208.21.225 0 .018-2.988.036-6.895.041l-6.894.01-.164.075c-.238.11-.406.273-.622.603-.624.951-.653 1.976-.08 2.839.178.268.45.542.636.641l.158.084 5.246.018 5.245.018-.78.953c-.857 1.045-.916 1.098-1.45 1.292-.324.119-.663.16-.9.11z"
                style="fill:#88181a;fill-opacity:0;stroke:#88181a;stroke-width:3;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" />

            <path
                d="M122.729 35.73c.301-.302.719-.732.928-.957l.38-.408.024.174c.06.446.202.905.409 1.317l.212.422h-2.501zm-6.344.364a9.176 9.176 0 0 0 1.228-.796l.203-.166.067.075c.093.104.863.814 1.036.955l.143.116h-3.019z"
                style="fill:#88181a;fill-opacity:0;stroke:#88181a;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" />

            <path
                d="M119 28.719a3.582 3.582 0 0 1-.014-.3c.003-.001.182.132.397.297l.39.3h-.753zM97.296 48.776a33.295 33.295 0 0 1 1.117-.644c.015-.004.124.143.243.326l.216.332h-.795c-.438 0-.79-.006-.78-.014z"
                style="fill:#88181a;fill-opacity:0;stroke:#88181a;stroke-width:1;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" />

            <path d="M105.919 24.753c-.205-.128-.357-.232-.338-.231.02 0 .27.063.557.138l.521.138-.183.093-.184.093z"
                  style="fill:#88181a;fill-opacity:0;stroke:#88181a;stroke-width:0;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" />

            <path
                d="M106.444 25.11a6.105 6.105 0 0 0-.501-.335 4.184 4.184 0 0 1-.398-.26c.01-.01 1.452.357 1.54.39.024.01-.062.066-.23.151a2.624 2.624 0 0 1-.291.137.404.404 0 0 1-.12-.084z"
                style="fill:#88181a;fill-opacity:0;stroke:#88181a;stroke-width:1;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" />

        </g>

    </svg>

</template>
