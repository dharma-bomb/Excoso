window.CMSStorage = {

    available: function() {
        return true;
    },

    uploadImage: async function(file, folder, progressCallback) {

        const CLOUD_NAME = "YOUR_CLOUDINARY_NAME";
        const UPLOAD_PRESET = "YOUR_UPLOAD_PRESET";

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
            throw new Error("Upload failed");
        }

        if (progressCallback) {
            progressCallback(100);
        }

        return data.secure_url;
    },

    deleteImage: async function(url) {
        return true;
    }

};
