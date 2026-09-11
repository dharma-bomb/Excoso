// admin/js/cloudinary.js

export async function uploadImage(file) {

    const CLOUD_NAME = "zegwar3g";
    const UPLOAD_PRESET = "excoso_products";

    const formData = new FormData();

    formData.append("file", file);
    formData.append("upload_preset", UPLOAD_PRESET);

    const response = await fetch(
        `https://api.cloudinary.com/v1_1/${zegwar3g}/image/upload`,
        {
            method: "POST",
            body: formData
        }
    );

    const data = await response.json();

    return data.secure_url;
}
