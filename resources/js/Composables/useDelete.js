import useAlert from "@/Composables/useAlert.js";
import { router } from "@inertiajs/vue3";
export default function useDelete(model) {
    const { confirm, toast } = useAlert();
    const deleteModel = (route) => {
        confirm.require({
            message: `Are you sure you want to update this ${model.toLowerCase()}?`,
            header: "Confirmation",
            icon: "pi pi-exclamation-triangle",
            rejectProps: {
                label: "Cancel",
                severity: "secondary",
                outlined: true,
            },
            acceptProps: {
                label: "Confirm",
                severity: "danger",
            },
            accept: () => {
                router.delete(route, {
                    onSuccess: () => {
                        toast.add({
                            severity: "success",
                            summary: "Success",
                            detail: `${model} Deleted Successfully.`,
                            life: 5000,
                        });
                    },
                    onError: () => {
                        toast.add({
                            severity: "error",
                            summary: "Error",
                            detail: `An error occured while trying to delete this ${model.toLowerCase()}.`,
                            life: 5000,
                        });
                    },
                });
            },
        });
    };
    return {
        deleteModel,
    };
}
