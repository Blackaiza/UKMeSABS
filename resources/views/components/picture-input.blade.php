<div class="flex items-center" x-data="picturePreview()">
    <!-- Container for Image and SVG -->
    <div class="rounded-md bg-gray-200 mr-2">
        <!-- Image Preview -->
        <img id="preview" src="" alt="" class="w-24 h-24 rounded-md object-cover" x-show="hasImage">
        <!-- SVG Placeholder -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
            class="w-24 h-24" x-show="!hasImage">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
        </svg>
    </div>

    <!-- Upload Button -->
    <div>
        <x-primary-button @click="document.getElementById('picture').click()" class="relative">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                </svg>              
                Upload picture
            </div>
            <input @change="showPreview(event)" type="file" name="picture" id="picture" class="absolute inset-0 -z-10 opacity-0">
        </x-primary-button>
    </div>

    <!-- AlpineJS Logic -->
    <script>
        function picturePreview() {
            return {
                hasImage: false, // Tracks whether an image is loaded
                showPreview(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const src = URL.createObjectURL(file);
                        document.getElementById('preview').src = src;
                        this.hasImage = true; // Show image
                    } else {
                        this.hasImage = false; // Show SVG
                    }
                },
            };
        }
    </script>
</div>
