import useAlert from "@/Composables/useAlert.js";
export default function useUpdate(form, route, model) {
    const { confirm, toast } = useAlert();

    const update = () => {
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
                severity: "success",
            },
            accept: () => {
                form.put(route, {
                    onSuccess: () => {
                        toast.add({
                            severity: "success",
                            summary: "Success",
                            detail: `${model} Updated Successfully.`,
                            life: 5000,
                        });
                    },
                    onError: () => {
                        toast.add({
                            severity: "error",
                            summary: "Error",
                            detail: `An error occured while trying to update the ${model.toLowerCase()} details.`,
                            life: 5000,
                        });
                    },
                });
            },
        });
    };

    return {
        update,
    };
}
