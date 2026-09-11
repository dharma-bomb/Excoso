window.CMSStorage = {

  uploadImage: async function(file, folder, progressCallback) {

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
      throw new Error("Upload failed");
    }

    if (progressCallback) {
      progressCallback(100);
    }

    return data.secure_url;
  },

  deleteImage: async function(url) {
    console.log("Cloudinary image delete skipped:", url);
    return true;
  }

};
