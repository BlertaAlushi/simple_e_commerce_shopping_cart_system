<script setup lang="ts">
import { computed, ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Button } from '@/components/ui/button';
import {
    Select,
    SelectTrigger,
    SelectValue,
    SelectContent,
    SelectItem,
} from '@/components/ui/select';
import { Tabs, TabsList, TabsTrigger, TabsContent } from '@/components/ui/tabs';
import { PageType } from '@/types';

const page = usePage<PageType>();

const languages = computed(() => page.props.languages ?? []);
const filters = computed(() => page.props.menu ?? []);

const props = defineProps({
    product: Object,
    isEdit: Boolean,
});

const imagePreview = ref(props.product?.image_url || null);

const form = useForm({
    price: props.product?.price || '',
    currency: props.product?.currency || 'USD',
    stock_quantity: props.product?.stock_quantity || '',
    mark_id: props.product?.mark_id || '',
    image: null,

    translations: languages.value.map((lang) => {
        const existing = props.product?.translations?.find(
            (t:any) => t.language_id === lang.id,
        );

        return {
            language_id: lang.id,
            name: existing?.name || '',
            description: existing?.description || '',
        };
    }),

    body_parts: props.product?.body_parts?.map((i:any) => i.id) || [],
    product_types: props.product?.product_types?.map((i:any) => i.id) || [],
    skin_types: props.product?.skin_types?.map((i:any) => i.id) || [],
    skin_concerns: props.product?.skin_concerns?.map((i:any) => i.id) || [],
    extras: props.product?.extras?.map((i:any) => i.id) || [],
});

const handleImage = (e) => {
    const file = e.target.files[0];
    form.image = file;
    imagePreview.value = URL.createObjectURL(file);
};

const toggleArray = (array, id) => {
    if (array.includes(id)) {
        return array.filter((i) => i !== id);
    }
    return [...array, id];
};

const submit = () => {
    form.post(
        props.isEdit
            ? route('products.update', props.product.id)
            : route('products.store'),
        { forceFormData: true },
    );
};
</script>

<template>
    <form @submit.prevent="submit" class="grid grid-cols-3 gap-6">
        <!-- LEFT SIDE -->
        <div class="col-span-2 space-y-6">
            <!-- Translations -->
            <Card>
                <CardHeader>
                    <CardTitle>Translations</CardTitle>
                </CardHeader>
                <CardContent>
                    <Tabs default-value="0">
                        <TabsList>
                            <TabsTrigger
                                v-for="(lang, index) in languages"
                                :key="lang.id"
                                :value="index.toString()"
                            >
                                {{ lang.code.toUpperCase() }}
                            </TabsTrigger>
                        </TabsList>

                        <TabsContent
                            v-for="(lang, index) in languages"
                            :key="lang.id"
                            :value="index.toString()"
                            class="mt-4 space-y-4"
                        >
                            <Input
                                v-model="form.translations[index].name"
                                :placeholder="`Name (${lang.code})`"
                            />

                            <Textarea
                                v-model="form.translations[index].description"
                                class="min-h-[120px]"
                                :placeholder="`Description (${lang.code})`"
                            />
                        </TabsContent>
                    </Tabs>
                </CardContent>
            </Card>

            <!-- Relations -->
            <Card>
                <CardHeader>
                    <CardTitle>Relations</CardTitle>
                </CardHeader>
                <CardContent class="grid grid-cols-2 gap-4">
                    <div v-for="item in bodyParts" :key="item.id">
                        <label class="flex items-center gap-2">
                            <input
                                type="checkbox"
                                :checked="form.body_parts.includes(item.id)"
                                @change="
                                    form.body_parts = toggleArray(
                                        form.body_parts,
                                        item.id,
                                    )
                                "
                            />
                            {{ item.name }}
                        </label>
                    </div>
                </CardContent>
            </Card>
        </div>

        <!-- RIGHT SIDE -->
        <div class="space-y-6">
            <!-- Image -->
            <Card>
                <CardHeader>
                    <CardTitle>Product Image</CardTitle>
                </CardHeader>
                <CardContent class="space-y-4">
                    <input type="file" @change="handleImage" />
                    <img
                        v-if="imagePreview"
                        :src="imagePreview"
                        class="w-full rounded-lg border"
                        alt="Product Image"
                    />
                </CardContent>
            </Card>

            <!-- Pricing -->
            <Card>
                <CardHeader>
                    <CardTitle>Pricing</CardTitle>
                </CardHeader>
                <CardContent class="space-y-4">
                    <Input
                        type="number"
                        v-model="form.price"
                        placeholder="Price"
                    />
                    <Input v-model="form.currency" placeholder="Currency" />
                    <Input
                        type="number"
                        v-model="form.stock_quantity"
                        placeholder="Stock"
                    />
                </CardContent>
            </Card>

            <!-- Brand -->
            <Card>
                <CardHeader>
                    <CardTitle>Brand</CardTitle>
                </CardHeader>
                <CardContent>
                    <Select v-model="form.mark_id">
                        <SelectTrigger>
                            <SelectValue placeholder="Select Brand" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem
                                v-for="mark in marks"
                                :key="mark.id"
                                :value="mark.id"
                            >
                                {{ mark.name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </CardContent>
            </Card>

            <Button class="w-full" :disabled="form.processing">
                {{ isEdit ? 'Update Product' : 'Create Product' }}
            </Button>
        </div>
    </form>
</template>
