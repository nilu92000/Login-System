<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Photo Gallery</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    h1 {
      text-align: center;
      padding: 20px;
      color: #333;
    }

    .gallery-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      padding: 20px;
      gap: 20px;
    }

    .photo-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
      padding: 10px;
      text-align: center;
      width: 200px;
      transition: transform 0.2s;
    }

    .photo-card:hover {
      transform: scale(1.05);
    }

    .photo-card img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 8px;
    }

    .add-btn {
      display: block;
      margin: 20px auto;
      background: #007bff;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }

    .add-btn:hover {
      background: #0056b3;
    }

    /* Popup Form Styling */
    .popup {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    .popup-content {
      background: white;
      padding: 25px;
      border-radius: 10px;
      width: 300px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    .popup-content h2 {
      text-align: center;
      margin-bottom: 15px;
    }

    .popup-content input,
    .popup-content select {
      width: 100%;
      padding: 8px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .popup-content button {
      width: 48%;
      padding: 10px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .popup-content .save-btn {
      background: #28a745;
      color: white;
    }

    .popup-content .cancel-btn {
      background: #dc3545;
      color: white;
    }

    .btn-group {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <h1>📸 My Photo Gallery</h1>
  <button class="add-btn" id="addPhotoBtn">Add Photo</button>

  <div class="gallery-container" id="gallery"></div>

  <!-- Popup Form -->
  <div class="popup" id="popupForm">
    <div class="popup-content">
      <h2>Add New Photo</h2>
      <form id="photoForm">
        <input type="text" id="imageName" placeholder="Enter Image Name" required>
        <select id="viewType" required>
          <option value="">Select View Type</option>
          <option value="Vertical">Vertical</option>
          <option value="Horizontal">Horizontal</option>
        </select>
        <input type="file" id="imageFile" accept="image/*" required>
        <div class="btn-group">
          <button type="submit" class="save-btn">Save</button>
          <button type="button" class="cancel-btn" id="cancelBtn">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const addPhotoBtn = document.getElementById("addPhotoBtn");
    const popupForm = document.getElementById("popupForm");
    const cancelBtn = document.getElementById("cancelBtn");
    const photoForm = document.getElementById("photoForm");
    const gallery = document.getElementById("gallery");

    // Show popup
    addPhotoBtn.addEventListener("click", () => {
      popupForm.style.display = "flex";
    });

    // Hide popup on cancel
    cancelBtn.addEventListener("click", () => {
      popupForm.style.display = "none";
      photoForm.reset();
    });

    // Add photo to gallery
    photoForm.addEventListener("submit", (e) => {
      e.preventDefault();

      const name = document.getElementById("imageName").value;
      const viewType = document.getElementById("viewType").value;
      const fileInput = document.getElementById("imageFile");

      if (fileInput.files.length === 0) {
        alert("Please select an image!");
        return;
      }

      const file = fileInput.files[0];
      const reader = new FileReader();

      reader.onload = function(event) {
        const imgURL = event.target.result;

        const card = document.createElement("div");
        card.classList.add("photo-card");

        card.innerHTML = `
          <img src="${imgURL}" alt="${name}">
          <h4>${name}</h4>
          <p>${viewType}</p>
        `;

        gallery.appendChild(card);
        popupForm.style.display = "none";
        photoForm.reset();
      };

      reader.readAsDataURL(file);
    });
  </script>
</body>
</html>
