<script setup>
import { router } from "@inertiajs/vue3";
import { watch, ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import useUpdate from "@/Composables/useUpdate";
import { Select as SelectPrime } from "primevue";
import useAlert from "@/Composables/useAlert.js";
const { confirm, toast } = useAlert();
const { targets, offices, filters, users, auth, employees } = defineProps({
    targets: {
        type: Object,
        required: true,
    },
    offices: {
        type: Object,
        required: false,
    },
    filters: {
        type: Object,
        required: true,
    },
    users: {
        type: Object,
        required: false,
    },
    group: {
        type: Object,
        required: false,
    },
    auth: {
        type: Object,
        required: false,
    },
    employees: {
        type: Object,
        required: false,
    },
    goals: {
        type: Object,
        required: false,
    },
    objectives: {
        type: Object,
        required: false,
    },
});

const office = ref(
    offices.length > 0 ? filters.office ?? offices[0].value.toString() : null
);
const user = ref(
    users.length > 0 ? filters.user ?? users[0].value.toString() : null
);

watch(office, (value) => {
    router.get(route("tasks.index"), {
        office: value,
        user: user.value,
    });
});

watch(user, (value) => {
    router.get(route("tasks.index"), {
        office: null,
        user: value,
    });
});

const form = useForm({
    user_task_id: null,
    target_number: null,
    success_indicator: null,
    individual_accountable: null,
    actual_accomplishments: null,
    actual_accomplishments_number: null,
    q: null,
    t: null,
    e: null,
    remark: null,
    link_to_evidence: null,
    pmt_remark: null,
});
const isEditModalVisible = ref(false);
const openEditModal = (id) => {
    form.user_task_id = id;
    isEditModalVisible.value = true;
};

const userOptions = computed(() => {
    return Array.isArray(users)
        ? users.map((user) => {
              return {
                  value: user.value.toString(),
                  label: user.label,
              };
          })
        : [];
});

const officeOptions = computed(() => {
    return Array.isArray(offices)
        ? offices.map((office) => {
              return {
                  value: office.value.toString(),
                  label: office.label,
              };
          })
        : [];
});
const employeeOptions = computed(() => {
    return Array.isArray(employees)
        ? employees.map((employee) => {
              return {
                  value: employee.value.toString(),
                  label: employee.label,
              };
          })
        : [];
});

const dateRange = [
    {
        value: 0,
        label: "January - June " + new Date().getFullYear(),
    },
    {
        value: 1,
        label: "July - December " + new Date().getFullYear(),
    },
];

const pdfForm = useForm({
    selectedColumns: [],
    full_name:
        userOptions.value.length == 0 ? null : userOptions.value[0].value,
    office_name:
        officeOptions.value.length == 0 ? null : officeOptions.value[0].value,
    name_of_employee: null,
    approved_by: null,
    ratee: null,
    final_rating_by: null,
    date_range: null,
});

watch(
    () => form.user_task_id,
    (value) => {
        if (!value) return;

        axios
            .get(route("user-tasks.show", value))
            .then((res) => {
                const {
                    actual_accomplishments,
                    actual_accomplishments_number,
                    individual_accountable,
                    link_to_evidence,
                    pmt_remark,
                    q,
                    t,
                    e,
                    remark,
                    success_indicator,
                    target_number,
                } = res.data;

                form.target_number = target_number;
                form.success_indicator = success_indicator;
                form.individual_accountable = individual_accountable;
                form.actual_accomplishments = actual_accomplishments;
                form.actual_accomplishments_number =
                    actual_accomplishments_number;
                form.q = q;
                form.t = t;
                form.e = e;
                form.remark = remark;
                form.link_to_evidence = link_to_evidence;
                form.pmt_remark = pmt_remark;
            })
            .catch((e) => console.log(e));
    }
);

const getCurrentTaskUpdateRoute = () => {
    return route("user-tasks.update", form.user_task_id);
};

const { update } = useUpdate(form, getCurrentTaskUpdateRoute, "Task");

const updateTask = async () => {
    const result = await update();
    if (result) {
        isEditModalVisible.value = false;
        form.reset();
    }
};

const isPdfModalOpen = ref(false);

const pdfDownloadOptions = [
    // {
    //     key: 1,
    //     value: "PROGRAMS, PROJECTS, ACTIVITIES",
    // },
    // {
    //     key: 2,
    //     value: "PERFORMANCE INDICATORS",
    // },
    {
        key: 3,
        value: "TARGET NUMBER",
    },
    {
        key: 4,
        value: "SUCCESS INDICATORS (TARGETS + MEASURES)",
    },
    {
        key: 5,
        value: "INDIVIDUAL ACCOUNTABLE",
    },
    {
        key: 6,
        value: "ACTUAL ACCOMPLISHMENTS NUMBER",
    },
    {
        key: 7,
        value: "ACTUAL ACCOMPLISHMENTS",
    },
    {
        key: 8,
        value: "RATING",
    },
    {
        key: 9,
        value: "REMARK",
    },
    {
        key: 10,
        value: "LINK TO EVIDENCE",
    },
    {
        key: 11,
        value: "PMT REMARK",
    },
];

const openPdfModal = () => {
    isPdfModalOpen.value = true;
};

const exportRoute = computed(() =>
    route("task-report.download", {
        user: user.value,
        office: office.value,
        selectedColumns: pdfForm.selectedColumns,
        full_name: pdfForm.full_name,
        office_name: pdfForm.office_name,
        name_of_employee: pdfForm.name_of_employee,
        approved_by: pdfForm.approved_by,
        ratee: pdfForm.ratee,
        final_rating_by: pdfForm.final_rating_by,
        date_range: pdfForm.date_range,
    })
);

const exportRouteExcel = computed(() =>
    route("task-report-excel.download", {
        user: user.value,
        office: office.value,
        selectedColumns: pdfForm.selectedColumns,
        full_name: pdfForm.full_name,
        office_name: pdfForm.office_name,
        name_of_employee: pdfForm.name_of_employee,
        approved_by: pdfForm.approved_by,
        ratee: pdfForm.ratee,
        final_rating_by: pdfForm.final_rating_by,
        date_range: pdfForm.date_range,
    })
);

const exportToExcel = () => {
    const {
        selectedColumns,
        full_name,
        office_name,
        name_of_employee,
        approved_by,
        ratee,
        final_rating_by,
        date_range,
    } = pdfForm;

    if (
        !selectedColumns ||
        !name_of_employee ||
        !approved_by ||
        !ratee ||
        !final_rating_by ||
        date_range == null
    ) {
        toast.add({
            severity: "error",
            summary: "Error",
            detail: `Please fill all the fields.`,
            life: 5000,
        });
        return;
    }
    window.open(exportRouteExcel.value, "_blank");
};

const exportToPdf = () => {
    const {
        selectedColumns,
        office_name,
        name_of_employee,
        approved_by,
        ratee,
        final_rating_by,
        date_range,
    } = pdfForm;

    if (
        !selectedColumns ||
        !name_of_employee ||
        !approved_by ||
        !ratee ||
        !final_rating_by ||
        date_range == null
    ) {
        toast.add({
            severity: "error",
            summary: "Error",
            detail: `Please fill all the fields.`,
            life: 5000,
        });
        return;
    }
    window.open(exportRoute.value, "_blank");
};

const groupForm = useForm({
    office_id: null,
    core_percentage: null,
    strategic_percentage: null,
    support_percentage: null,
});
const isGroupModalVisible = ref(false);
const openGroupModal = () => {
    isGroupModalVisible.value = true;
    groupForm.office_id = office.value;
};

const updateGroup = () => {
    groupForm.put(route("groups.update"), {
        onSuccess: () => {
            toast.add({
                severity: "success",
                summary: "Success",
                detail: `Updated Successfully.`,
                life: 5000,
            });
            isGroupModalVisible.value = false;
            groupForm.reset();
        },
        onError: (e) => {
            toast.add({
                severity: "error",
                summary: "Error",
                detail: e.percentage ?? "Failed to update.",
                life: 5000,
            });
        },
    });
};

const getColumnsCount = (group) => {
    let columnsCount = 0;
    if (targets[group]) {
        for (const item of targets[group]) {
            if (item.sub_targets) {
                if (Array.isArray(item.sub_targets)) {
                    for (const subItem of item.sub_targets) {
                        if (subItem.user_tasks.ave) columnsCount++;
                    }
                } else if (typeof item.sub_targets === "object") {
                    for (const key in item.sub_targets) {
                        const subItem = item.sub_targets[key];
                        if (subItem.user_tasks.ave) columnsCount++;
                    }
                }
            }
        }
    }
    return columnsCount;
};

const getGroupTotal = (percentage, group) => {
    const result = ((percentage / 100) * getSubrating(group)).toFixed(2);

    return isNaN(result) ? 0 : result;
};

const getSubrating = (group) => {
    const result = (
        targets[group]?.reduce(
            (sum, target) => sum + parseFloat(target.subrating || 0),
            0
        ) / getColumnsCount(group) ?? 1
    ).toFixed(2);
    return isNaN(result) ? null : result;
};

const hasSubTargetsForObjective = (target, objectiveId) => {
    if (!target || !target.sub_targets || !Array.isArray(target.sub_targets)) {
        console.log(target);
        console.log("No sub targets found for this objective.");
        return false;
    }
    return target.sub_targets.some(
        (st) => st && st.objective_id === objectiveId
    );
};

const filterSubTargetsForObjective = (target, objectiveId) => {
    if (!target || !target.sub_targets || !Array.isArray(target.sub_targets)) {
        console.log("No sub targets found for this target.");
        return [];
    }
    console.log(
        target.sub_targets.filter((st) => st && st.objective_id === objectiveId)
    );
    return target.sub_targets.filter(
        (st) => st && st.objective_id === objectiveId
    );
};
</script>
<template>
    <!-- Group Modal -->
    <Dialog
        modal
        v-model:visible="isGroupModalVisible"
        :style="{ width: '25rem' }"
    >
        <FormInput
            label="Core Percentage"
            :errorMessage="groupForm.errors.core_percentage"
        >
            <Input type="number" required v-model="groupForm.core_percentage" />
        </FormInput>
        <FormInput
            label="Strategic Percentage"
            :errorMessage="groupForm.errors.strategic_percentage"
        >
            <Input
                type="number"
                required
                v-model="groupForm.strategic_percentage"
            />
        </FormInput>
        <FormInput
            label="Support Percentage"
            :errorMessage="groupForm.errors.support_percentage"
        >
            <Input
                type="number"
                required
                v-model="groupForm.support_percentage"
            />
        </FormInput>
        <div class="flex justify-end">
            <Button @click="updateGroup" class="text-white">Save</Button>
        </div>
        <template #header> Edit Percentage </template>
    </Dialog>
    <!-- Pdf Modal -->
    <Dialog
        v-model:visible="isPdfModalOpen"
        modal
        header="Export To PDF"
        :style="{ width: '50rem' }"
    >
        <div class="space-y-3">
            <FormContainer>
                <FormInput
                    label="Your office name"
                    :errorMessage="pdfForm.errors.office_name"
                >
                    <SelectPrime
                        disabled
                        v-model="pdfForm.office_name"
                        :options="officeOptions"
                        optionLabel="label"
                        optionValue="value"
                        placeholder="Select from options"
                        class="w-full"
                    />
                </FormInput>
                <FormInput
                    label="Name Of Employee"
                    :errorMessage="pdfForm.errors.name_of_employee"
                >
                    <SelectPrime
                        v-model="pdfForm.name_of_employee"
                        :options="employeeOptions"
                        optionLabel="label"
                        optionValue="value"
                        placeholder="Select from options"
                        class="w-full"
                    />
                </FormInput>
                <FormInput
                    label="Approved By"
                    :errorMessage="pdfForm.errors.approved_by"
                >
                    <SelectPrime
                        v-model="pdfForm.approved_by"
                        :options="employeeOptions"
                        optionLabel="label"
                        optionValue="value"
                        placeholder="Select from options"
                        class="w-full"
                    />
                </FormInput>
                <FormInput label="Ratee" :errorMessage="pdfForm.errors.ratee">
                    <SelectPrime
                        v-model="pdfForm.ratee"
                        :options="employeeOptions"
                        optionLabel="label"
                        optionValue="value"
                        placeholder="Select from options"
                        class="w-full"
                    />
                </FormInput>
                <FormInput
                    label="Final Rating By:"
                    :errorMessage="pdfForm.errors.final_rating_by"
                >
                    <SelectPrime
                        v-model="pdfForm.final_rating_by"
                        :options="employeeOptions"
                        optionLabel="label"
                        optionValue="value"
                        placeholder="Select from options"
                        class="w-full"
                    />
                </FormInput>

                <FormInput
                    label="Date Range:"
                    :errorMessage="pdfForm.errors.date_range"
                >
                    <SelectPrime
                        v-model="pdfForm.date_range"
                        :options="dateRange"
                        optionLabel="label"
                        optionValue="value"
                        placeholder="Select from options"
                        class="w-full"
                    />
                </FormInput>
            </FormContainer>
            <FormContainer>
                <SpanXS class="col-span-2">Columns to include</SpanXS>
                <div
                    v-for="option in pdfDownloadOptions"
                    class="flex items-center gap-2"
                >
                    <Checkbox
                        v-model="pdfForm.selectedColumns"
                        :value="option.key"
                        name="selectedColumns[]"
                    />
                    <label class="text-xs text-gray-600">
                        {{ option.value }}
                    </label>
                </div>
            </FormContainer>
            <div class="flex justify-end gap-3">
                <Button class="text-white" @click="exportToExcel"
                    >Export to Excel</Button
                >
                <Button class="text-white" @click="exportToPdf"
                    >Export to PDF</Button
                >
            </div>
        </div>
    </Dialog>

    <!-- Edit Task Modal -->
    <Dialog
        v-model:visible="isEditModalVisible"
        modal
        header="Update Details"
        :style="{ width: '25rem' }"
    >
        <FormInput
            label="TARGET NUMBER"
            :errorMessage="form.errors.target_number"
        >
            <Input v-model="form.target_number" disabled />
        </FormInput>
        <FormInput
            label="SUCCESS INDICATORS (TARGETS + MEASURES)"
            :errorMessage="form.errors.success_indicator"
        >
            <Input v-model="form.success_indicator" />
        </FormInput>
        <FormInput
            label="INDIVIDUAL ACCOUNTABLE"
            :errorMessage="form.errors.individual_accountable"
        >
            <Input v-model="form.individual_accountable" />
        </FormInput>
        <FormInput
            label="ACTUAL ACCOMPLISHMENTS NUMBER"
            :errorMessage="form.errors.actual_accomplishments_number"
        >
            <Input
                v-model="form.actual_accomplishments_number"
                type="number"
                onkeydown="return !(event.keyCode === 69 || event.keyCode === 187 || event.keyCode === 189)"
            />
        </FormInput>
        <FormInput
            label="ACTUAL ACCOMPLISHMENTS"
            :errorMessage="form.errors.actual_accomplishments"
        >
            <Input v-model="form.actual_accomplishments" />
        </FormInput>
        <FormInput label="Q" :errorMessage="form.errors.q">
            <Input
                v-model="form.q"
                type="number"
                onkeydown="return !(event.keyCode === 69 || event.keyCode === 187 || event.keyCode === 189)"
            />
        </FormInput>
        <FormInput label="T" :errorMessage="form.errors.t">
            <Input
                v-model="form.t"
                type="number"
                onkeydown="return !(event.keyCode === 69 || event.keyCode === 187 || event.keyCode === 189)"
            />
        </FormInput>
        <FormInput label="E" :errorMessage="form.errors.e">
            <Input
                v-model="form.e"
                type="number"
                onkeydown="return !(event.keyCode === 69 || event.keyCode === 187 || event.keyCode === 189)"
            />
        </FormInput>
        <FormInput label="Remark" :errorMessage="form.errors.remark">
            <Input v-model="form.remark" />
        </FormInput>
        <FormInput
            label="LINK TO EVIDENCE"
            :errorMessage="form.errors.link_to_evidence"
        >
            <Input v-model="form.link_to_evidence" />
        </FormInput>
        <FormInput
            v-if="auth.is_admin"
            label="PMT REMARK"
            :errorMessage="form.errors.pmt_remark"
        >
            <Input v-model="form.pmt_remark" />
        </FormInput>
        <DivFlexCenter class="justify-end">
            <Button @click="updateTask" class="text-white">Update</Button>
        </DivFlexCenter>
    </Dialog>
    <MainLayout>
        <Button class="text-white" @click="openPdfModal">Export</Button>
        <DivFlexCenter class="gap-2">
            <!-- <Select v-if="users.length > 0" v-model="user">
                <SelectTrigger>
                    <SelectValue placeholder="Select a user" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectLabel>Users</SelectLabel>
                        <SelectItem
                            v-for="user in users"
                            :value="user.value.toString()"
                        >
                            {{ user.label }}
                        </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select> -->

            <Select v-model="office">
                <SelectTrigger>
                    <SelectValue placeholder="Select an office" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectLabel>Offices</SelectLabel>
                        <SelectItem
                            v-for="office in offices"
                            :value="office.value.toString()"
                        >
                            {{ office.label }}
                        </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </DivFlexCenter>

        <DivFlexCol class="gap-5">
            <!-- <DivFlexCol class="items-center justify-center gap-3">
                <H1Bold> DEPARTMENT PERFORMANCE COMMITMENT AND REVIEW </H1Bold>
                <SpanXS
                    >I, FULL NAME HERE, POSITION and OFFICIAL DESIGNATION of the
                    OFFICE NAME, commit to deliver and agree to be rated on the
                    attainment of following targets in accordance with the
                    indicated measure for the period (January - June
                    2025)</SpanXS
                >
            </DivFlexCol>

            <DivFlexCenter class="justify-between">
                <DivFlexCol class="w-full gap-1">
                    <Label>Approved By</Label>
                    <SpanXS>Name: </SpanXS>
                    <SpanXS>Position: </SpanXS>
                    <SpanXS>Date: </SpanXS>
                </DivFlexCol>
                <DivFlexCol class="w-full">
                    <SpanXS>Name of Employee:</SpanXS>
                    <SpanXS>Date:</SpanXS>

                    <DivFlexCol class="mt-3 gap-1">
                        <Label>Rating Scale:</Label>
                        <SpanXS>5 - Outstanding</SpanXS>
                        <SpanXS>4 - Very Satisfactory</SpanXS>
                        <SpanXS>3 - Satisfactory</SpanXS>
                        <SpanXS>2 - Unsatisfactory</SpanXS>
                        <SpanXS>1 - Poor</SpanXS>
                    </DivFlexCol>
                </DivFlexCol>
            </DivFlexCenter> -->

            <DivFlexCol
                class="w-full h-auto rounded-lg border border-gray/20 space-y-5 overflow-auto overflow-x-auto scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-300 hover:scrollbar-thumb-gray-400"
            >
                <Table>
                    <TableHead>
                        <TH>PROGRAMS, PROJECTS, ACTIVITIES</TH>
                        <TH>PERFORMANCE INDICATORS</TH>
                        <TH>TARGET NUMBER</TH>
                        <TH>SUCCESS INDICATORS (TARGETS + MEASURES)</TH>
                        <TH>INDIVIDUAL ACCOUNTABLE</TH>
                        <TH>ACTUAL ACCOMPLISHMENTS NUMBER</TH>
                        <TH>ACTUAL ACCOMPLISHMENTS</TH>
                        <TH colspan="4" class="divide-x-2 divide-gray-300">
                            RATING
                            <TH>Q</TH>
                            <TH>T</TH>
                            <TH>E</TH>
                            <TH>AVE</TH>
                        </TH>
                        <TH>REMARK</TH>
                        <TH>LINK TO EVIDENCE</TH>
                        <TH>PMT REMARK</TH>
                        <TH>ACTION</TH>
                    </TableHead>
                    <TableHead>
                        <TH colspan="12">
                            CORE FUNCTIONS RESEARCH AND EXTENSION
                        </TH>
                    </TableHead>
                    <!-- New goals sedtion -->
                    <TableBody v-for="goal in goals" :key="goal.id">
                        <tr>
                            <TD colspan="12"> {{ goal.description }}</TD>
                        </tr>

                        <template
                            v-for="objective in goal.objectives"
                            :key="objective.id"
                        >
                            <tr>
                                <TD colspan="12" class="text-gray-400">
                                    {{ objective.description }}
                                </TD>
                            </tr>

                            <!-- Loop through core targets that match this objective -->
                            <template
                                v-for="target in targets['core']"
                                :key="target.id"
                            >
                                <!-- Only display if this target has sub-targets for this objective -->
                                <template
                                    v-if="
                                        hasSubTargetsForObjective(
                                            target,
                                            objective.id
                                        )
                                    "
                                >
                                    <tr>
                                        <TD
                                            :rowspan="
                                                filterSubTargetsForObjective(
                                                    target,
                                                    objective.id
                                                ).length + 1
                                            "
                                            class="border-r border-gray-300"
                                        >
                                            {{ target.description }}
                                        </TD>
                                    </tr>

                                    <tr
                                        v-for="sub_target in filterSubTargetsForObjective(
                                            target,
                                            objective.id
                                        )"
                                        :key="sub_target.id"
                                        class="divide-x divide-gray-300"
                                    >
                                        <TD>{{ sub_target.description }}</TD>
                                        <TD
                                            v-for="user_task in sub_target.user_tasks"
                                        >
                                            {{ user_task }}
                                        </TD>
                                        <TD>
                                            <EditButton
                                                @click="
                                                    openEditModal(
                                                        sub_target.user_task_id
                                                    )
                                                "
                                            />
                                        </TD>
                                    </tr>
                                </template>
                            </template>
                        </template>
                    </TableBody>

                    <TableBody>
                        <tr class="divide-x divide-gray-300">
                            <TD colspan="7"></TD>
                            <TD colspan="4">
                                SUBRATING:
                                {{ getSubrating("core") }}</TD
                            >
                            <TD colspan="4"></TD>
                        </tr>
                    </TableBody>

                    <TableHead>
                        <TH colspan="12"> STRATEGIC </TH>
                    </TableHead>

                    <TableBody v-for="target in targets['strategic']">
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
                            <TD>{{ sub_target.description }}</TD>
                            <TD v-for="user_task in sub_target.user_tasks">{{
                                user_task
                            }}</TD>

                            <TD>
                                <EditButton
                                    @click="
                                        openEditModal(sub_target.user_task_id)
                                    "
                                />
                            </TD>
                        </tr>
                    </TableBody>

                    <TableBody>
                        <tr class="divide-x divide-gray-300">
                            <TD colspan="7"></TD>
                            <TD colspan="4"
                                >SUBRATING: {{ getSubrating("strategic") }}</TD
                            >
                            <TD colspan="4"></TD>
                        </tr>
                    </TableBody>

                    <TableHead>
                        <TH colspan="12"> SUPPORT</TH>
                    </TableHead>

                    <TableBody v-for="target in targets['support']">
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
                            <TD>{{ sub_target.description }}</TD>
                            <TD v-for="user_task in sub_target.user_tasks">{{
                                user_task
                            }}</TD>

                            <TD>
                                <EditButton
                                    @click="
                                        openEditModal(sub_target.user_task_id)
                                    "
                                />
                            </TD>
                        </tr>
                    </TableBody>

                    <TableBody>
                        <tr class="divide-x divide-gray-300">
                            <TD colspan="7"></TD>
                            <TD colspan="4"
                                >SUBRATING: {{ getSubrating("support") }}</TD
                            >
                            <TD colspan="4"></TD>
                        </tr>
                    </TableBody>
                    <tr class="divide-x divide-gray-300">
                        <TD colspan="7"></TD>
                        <TD colspan="4"
                            >Core: {{ getGroupTotal(group.core, "core") }}</TD
                        >
                        <TD colspan="3">Core Percentage: {{ group.core }}</TD>

                        <TD colspan="1">
                            <EditButton @click="openGroupModal()" />
                        </TD>
                    </tr>
                    <tr class="divide-x divide-gray-300">
                        <TD colspan="7"></TD>
                        <TD colspan="4"
                            >Strategic:
                            {{
                                getGroupTotal(group.strategic, "strategic")
                            }}</TD
                        >
                        <TD colspan="3"
                            >Strategic Percentage: {{ group.strategic }}</TD
                        >

                        <TD colspan="1"> </TD>
                    </tr>
                    <tr class="divide-x divide-gray-300">
                        <TD colspan="7"></TD>
                        <TD colspan="4"
                            >Support:
                            {{ getGroupTotal(group.support, "support") }}</TD
                        >
                        <TD colspan="3"
                            >Support Percentage: {{ group.support }}</TD
                        >

                        <TD colspan="1"> </TD>
                    </tr>
                    <tr class="divide-x divide-gray-300">
                        <TD colspan="7"></TD>
                        <TD colspan="4"
                            >Final Ave:
                            {{
                                isNaN(
                                    (
                                        parseFloat(
                                            getGroupTotal(group.core, "core")
                                        ) ??
                                        0 +
                                            parseFloat(
                                                getGroupTotal(
                                                    group.strategic,
                                                    "strategic"
                                                )
                                            ) ??
                                        0 +
                                            parseFloat(
                                                getGroupTotal(
                                                    group.support,
                                                    "support"
                                                )
                                            ) ??
                                        0
                                    ).toFixed(2)
                                )
                                    ? null
                                    : (
                                          parseFloat(
                                              getGroupTotal(group.core, "core")
                                          ) +
                                          parseFloat(
                                              getGroupTotal(
                                                  group.strategic,
                                                  "strategic"
                                              )
                                          ) +
                                          parseFloat(
                                              getGroupTotal(
                                                  group.support,
                                                  "support"
                                              )
                                          )
                                      ).toFixed(2)
                            }}</TD
                        >
                        <TD colspan="4"> </TD>
                    </tr>
                </Table>
            </DivFlexCol>

            <!-- <DivFlexCenter class="justify-between">
                <DivFlexCol class="gap-1 w-full">
                    <SpanXS>Name and Signature of Ratee:</SpanXS>
                    <SpanXS>Position:</SpanXS>
                    <SpanXS>Date:</SpanXS>
                </DivFlexCol>
                <DivFlexCol class="gap-1 w-full">
                    <SpanXS>Final Rating by:</SpanXS>
                    <SpanXS>Position:</SpanXS>
                    <SpanXS>Date:</SpanXS>
                </DivFlexCol>
            </DivFlexCenter> -->
        </DivFlexCol>
    </MainLayout>
</template>
