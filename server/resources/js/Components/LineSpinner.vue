<script setup lang="ts">
import { computed, defineProps } from 'vue';

// https://github.com/JoshK2/vue-spinners-css

const props = defineProps({
    loading: {
        type: Boolean,
        default: true,
    },
    size: {
        type: Number,
        default: 80,
    },
    color: {
        type: String,
        default: '#7f58af',
    },
    duration: {
        type: String,
        default: '1.2s',
    },
});

const spinnerStyleDuration = {
    animationDuration: props.duration,
};

const spinnerStyle = {
    top: `${props.size * 0.0375}px`,
    left: `${props.size * 0.4625}px`,
    width: `${props.size * 0.075}px`,
    height: `${props.size * 0.225}px`,
    background: props.color,
};

function calcPropertyValue(originalValue: string, modificator: number) {
    const timeQuantityOuter = +originalValue.match(/^\d*\.?\d+/)![0];
    const timeUnit = originalValue.match(/s|(ms)$/)![0];
    const timeQuantityInner =
        Math.round(timeQuantityOuter * 1000 * modificator) / 1000;

    return { animationDelay: timeQuantityInner + timeUnit };
}

const divsStyles = computed(() => {
    const styles = [];
    for (let i = 1; i <= 12; i++) {
        styles.push(calcPropertyValue(props.duration, 0.083 * i - 1));
    }

    return styles;
});
</script>

<template>
    <div
        class="lds-spinner"
        v-show="loading"
        :style="{ width: `${size}px`, height: `${size}px` }"
    >
        <div
            v-for="i in 12"
            :key="`lds-spinner-${i}`"
            :style="[
                spinnerStyleDuration,
                { transformOrigin: `${size * 0.5}px ${size * 0.5}px` },
                divsStyles[i - 1],
                { transform: `rotate(${30 * i}deg)` },
            ]"
        >
            <div class="div-after" :style="[spinnerStyle]"></div>
        </div>
    </div>
</template>

<style scoped>
.lds-spinner {
    display: inline-block;
    position: relative;
}
.lds-spinner div {
    animation-name: lds-spinner;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
}
.lds-spinner div .div-after {
    content: ' ';
    display: block;
    position: absolute;
    border-radius: 20%;
    background: #fff;
}

@keyframes lds-spinner {
    0% {
        opacity: 1;
    }
    100% {
        opacity: 0;
    }
}
</style>
