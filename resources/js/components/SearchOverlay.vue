<script setup lang="ts">
import { ref, watch, nextTick, defineProps } from 'vue';
import { Search, X } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    modelValue: Boolean,
});

const query = ref('');
const inputRef = ref<HTMLInputElement>();

watch(
    () => props.modelValue,
    async (val) => {
        if (val) {
            await nextTick();
            inputRef.value?.focus();
        }
    },
);

// Close search row
function close() {
    query.value = '';
}

function submitSearch() {
    const trimmedQuery = query.value.trim();
    if (!trimmedQuery) return;

    // Keep other query params if needed
    const params: Record<string, string> = { q: trimmedQuery };

    // Sends GET request to current URL with query param
    router.get(window.location.pathname, params, {
        preserveState: true,
        replace: true,
        preserveScroll: true,
    });
}
function handleKeyPress(e: KeyboardEvent) {
    if (e.key === 'Enter') submitSearch();
}
</script>

<template>
    <transition name="slide-down">
        <div
            v-if="modelValue"
            class="w-full border-b border-gray-200 bg-white shadow-sm"
        >
            <div class="mx-auto flex w-full max-w-5xl items-center gap-2 p-4">
                <input
                    ref="inputRef"
                    v-model="query"
                    type="text"
                    placeholder="Search products..."
                    class="flex-1 rounded border border-gray-300 px-3 py-2 transition focus:ring-1 focus:ring-black focus:outline-none"
                    @keypress="handleKeyPress"
                />
                <Button
                    variant="ghost"
                    size="icon"
                    class="group h-9 w-9 cursor-pointer"
                    @click="submitSearch"
                >
                    <Search class="size-5 opacity-80 group-hover:opacity-100" />
                </Button>
                <Button
                    variant="ghost"
                    size="icon"
                    class="group h-9 w-9 cursor-pointer"
                    @click="close"
                >
                    <X class="size-5 opacity-80 group-hover:opacity-100" />
                </Button>
            </div>
        </div>
    </transition>
</template>
