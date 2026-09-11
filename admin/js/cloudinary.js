// admin/js/cloudinary.js

window.uploadImage = async function(file) {

    const CLOUD_NAME = "zegwar3g";
    const UPLOAD_PRESET = "excoso_products";

    const formData = new FormData();

    formData.append("file", file);
    formData.append("upload_preset", UPLOAD_PRESET);

    const response = await fetch(
        `https://api.cloudinary.com/v1_1/${CLOUD_NAME}/image/upload`,
        {
            method: "POST",
            body: formData
        }
    );

    const data = await response.json();

    if (!data.secure_url) {
        console.error(data);
        throw new Error("Cloudinary upload failed");
    }

    return data.secure_url;
};
