import { useToast as toaster } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
export default function useToast() {
    const toast = toaster();
    const confirm = useConfirm();
    return {
        toast,
        confirm,
    };
}
