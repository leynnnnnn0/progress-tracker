<script setup>
import useUpdate from "@/Composables/useUpdate";
defineProps({
    offices: {
        type: Object,
        required: true,
    },
    targets: {
        type: Object,
        required: true,
    },
});

import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const visible = ref(false);
const updateTarget = (office_id, sub_target_id) => {
    console.log(office_id);
    console.log(sub_target_id);
    form.office_id = office_id;
    form.sub_target_id = sub_target_id;
    visible.value = true;
};

const form = useForm({
    office_id: null,
    sub_target_id: null,
    target_number: null,
});

const { update } = useUpdate(
    form,
    route("offices-target.update-target-number"),
    "Target Number"
);

const updateTargetNumber = async () => {
    const result = await update();
    result ? (visible.value = false) : (visible.value = true);
};
</script>

<template>
    <MainLayout>
        <Heading>Offices Target</Heading>

        <DivFlexCol
            class="w-full h-auto rounded-lg border border-gray/20 space-y-5 overflow-auto overflow-x-auto scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-300 hover:scrollbar-thumb-gray-400"
        >
            <Table>
                <TableHead>
                    <TH>PROGRAMS, PROJECTS, ACTIVITIES</TH>
                    <TH>PERFORMANCE INDICATORS</TH>
                    <TH v-for="office in offices">
                        {{ office }}
                    </TH>
                </TableHead>
                <TableBody v-for="target in targets">
                    <tr>
                        <TD
                            :rowspan="target.sub_targets.length + 1"
                            class="border-r border-gray-300"
                            >{{ target.description }}</TD
                        >
                    </tr>
                    <tr
                        v-for="sub_target in target.sub_targets"
                        class="divide-x divide-gray-300"
                    >
                        <TD>
                            {{ sub_target.description }}
                        </TD>
                        <TD
                            v-for="target_number in sub_target.offices_target"
                            @click="
                                updateTarget(
                                    target_number.office_id,
                                    sub_target.sub_target_id
                                )
                            "
                        >
                            {{ target_number.target_number }}
                        </TD>
                    </tr>
                </TableBody>
            </Table>
        </DivFlexCol>

        <Dialog
            v-model:visible="visible"
            header="Update Target Number"
            :style="{ width: '25rem' }"
        >
            <FormInput
                label="Target Number"
                :errorMessage="form.errors.target_number"
            >
                <Input
                    v-model="form.target_number"
                    type="number"
                    onkeydown="return !(event.keyCode === 69 || event.keyCode === 187 || event.keyCode === 189)"
                />
            </FormInput>

            <section class="flex justify-end mt-5">
                <Button @click="updateTargetNumber" class="text-white"
                    >Update</Button
                >
            </section>
        </Dialog>
    </MainLayout>
</template>
