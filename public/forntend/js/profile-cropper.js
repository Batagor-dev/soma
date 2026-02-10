let cropper;

const uploadInput = document.getElementById("upload");
const imageToCrop = document.getElementById("imageToCrop");
const avatarPreview = document.getElementById("uploadedAvatar");
const croppedInput = document.getElementById("croppedImage");
const modalElement = document.getElementById("cropperModal");
const cropperModal = new bootstrap.Modal(modalElement);

uploadInput.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (ev) => {
        imageToCrop.src = ev.target.result;
        cropperModal.show();
    };
    reader.readAsDataURL(file);
});

modalElement.addEventListener("shown.bs.modal", () => {
    cropper = new Cropper(imageToCrop, {
        aspectRatio: 1,
        viewMode: 1,
        dragMode: "move",
        autoCropArea: 1,
        responsive: true,
    });
});

modalElement.addEventListener("hidden.bs.modal", () => {
    cropper?.destroy();
    cropper = null;
});

document.getElementById("cropAndSave").addEventListener("click", () => {
    if (!cropper) return;

    const canvas = cropper.getCroppedCanvas({
        width: 400,
        height: 400,
    });

    canvas.toBlob(
        (blob) => {
            avatarPreview.src = URL.createObjectURL(blob);

            const file = new File([blob], "avatar.jpg", { type: "image/jpeg" });
            const dt = new DataTransfer();
            dt.items.add(file);
            croppedInput.files = dt.files;

            cropperModal.hide();
        },
        "image/jpeg",
        0.9
    );
});
