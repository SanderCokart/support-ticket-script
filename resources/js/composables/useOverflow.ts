import {computed, watch} from 'vue';
import type {Ref} from 'vue';
import {MaybeRefOrGetter} from '@vueuse/core';

//param must extend HTMLElement

const UseOverflow = (target: Ref<HTMLElement | undefined>) => {
    return computed( () => {
        if (!target.value) return false;
        return target.value?.scrollHeight > target.value?.clientHeight;
    });
};

export default UseOverflow;
