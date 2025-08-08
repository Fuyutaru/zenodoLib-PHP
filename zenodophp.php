<?php

class ZenodoUploader{
    /**
     * The url for the Zenodo API.
     * @var string
     */
    private string $zenodoApiUrl;

    /**
     * The API key for Zenodo.
     * @var string|null
     */
    private ?string $zenodoApiKey;

    /**
     * The DOI for the Zenodo record.
     * @var string|null
     */
    private ?string $doi;

    /**
     * Title of the Zenodo record.
     * @var string|null
     */
    private ?string $title;

    /**
     * Description of the Zenodo record.
     * @var string|null
     */
    private ?string $description;

    /**
     * The author of the Zenodo record.
     * @var string|null
     */
    private ?string $author;

    /**
     * The organization of the author associated with the Zenodo record.
     * @var string|null
     */
    private ?string $organization;

    /**
     * The contributors of the Zenodo record.
     * @var array|null
     */
    private ?array $contributors; // le full array avec les dico a l'interieur

    /**
     * The tags or keywords associated with the Zenodo record.
     * @var array|null
     */
    private ?array $tags;

    /**
     * The resource type of the Zenodo record.
     * @var string|null
     */
    private ?string $resourceType;

    /**
     * The date interval for the Zenodo record.
     * @var string|null
     */
    private ?string $dateinterval; 

    /**
     * The visibility of the Zenodo record.
     * 
     * Open access: 'open', Restricted access: 'restricted', Closed access: 'closed'.
     * @var string|null
     */
    private ?string $visibility;

    /**
     * The communities associated with the Zenodo record.
     * @var array|null
     */
    private ?array $communities = [];

    /**
     * The metadata for the Zenodo record.
     * 
     * This is an associative array that contains all the metadata fields.
     * 
     * It is built from the individual metadata fields set by the user.
     * @var array
     */
    private array $metadata = [];

    /**
     * The name of the file field in the form.
     * 
     * This is used to identify which file to upload.
     * @var string|null
     */
    private ?string $fileFieldName;

    /**
     * The DOI number for the Zenodo record.
     * @var string|null
     */
    private ?string $doiNumber;

    /**
     * The license for the Zenodo record.
     * @var string|null
     */
    private ?string $license;


    /**
     * Constructor for the ZenodoUploader class.
     * @param bool $sandbox If true, use the sandbox API; otherwise, use the production API.
     */
    public function __construct($sandbox = false) {
        if ($sandbox) {
            $this->zenodoApiUrl = 'https://sandbox.zenodo.org/api/deposit/depositions';
        } else {
            $this->zenodoApiUrl = 'https://zenodo.org/api/deposit/depositions';
        }

    }

    /**
     * Function to set the Zenodo API key.
     * 
     * This key is required for authentication when uploading to Zenodo.
     * @param string $apiKey
     * @return void
     */
    public function setZenodoApiKey(string $apiKey): void {
        $this->zenodoApiKey = $apiKey;
    }

    /**
     * Function to get the Zenodo API key.
     * @return string|null
     */
    public function getZenodoApiKey(): ?string {
        return $this->zenodoApiKey;
    }

    /**
     * Function to set the DOI for the Zenodo record.
     * @param string $doi
     * @return void
     */
    public function setDoi(string $doi): void {
        $this->doi = $doi;
    }

    /**
     * Function to get the DOI for the Zenodo record.
     * @return string|null
     */
    public function getDoi(): ?string {
        return $this->doi;
    }

    /**
     * Function to set the title for the Zenodo record.
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * Function to get the title for the Zenodo record.
     * @return string|null
     */
    public function getTitle(): ?string {
        return $this->title;
    }

    /**
     * Function to set the description for the Zenodo record.
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * Function to get the description for the Zenodo record.
     * @return string|null
     */
    public function getDescription(): ?string {
        return $this->description;
    }

    /**
     * Function to set the author for the Zenodo record.
     * 
     * The String should be in the format "First, Last" or "First Last" or "First".
     * @param string $author
     * @return void
     */
    public function setAuthor(string $author): void {
        if (strpos($author, ",") !== false) {
            $this->author = $author;
        } else if (strpos($author, " ") !== false) {
            $tmp = explode(' ', $author);
            $this->author = join(', ', $tmp);
        } else{
            $this->author = $author;
        }
    }

    /**
     * Function to get the authors for the Zenodo record.
     * @return string|null
     */
    public function getAuthors(): ?string {
        return $this->author;
    }

    /**
     * Function to set the organization of the author for the Zenodo record.
     * @param string $organization
     * @return void
     */
    public function setOrganization(string $organization): void {
        $this->organization = $organization;
    }

    /**
     * Function to get the organization of the author for the Zenodo record.
     * @return string|null
     */
    public function getOrganization(): ?string {
        return $this->organization;
    }

    /**
     * Function to set contributors for the metadata.
     * 
     * At minimum, it should be an array of associative arrays with 'name' and 'role' keys.
     * 
     * example: [['name' => 'John, Doe', 'role' => 'Editor'], ['name' => 'Jane, Smith', 'role' => 'Reviewer']]
     * 
     * At maximum, it can be an array of associative arrays with 'name', 'type', 'affiliation', 'orcid' and 'gnd' keys.
     * @param array $contributors
     * @return void
     */
    public function setContributors(array $contributors): void {
        $this->contributors = $contributors;
    }

    /**
     * Function to get the contributors for the Zenodo record.
     * @return array|null
     */
    public function getContributors(): ?array {
        return $this->contributors;
    }

    /**
     * Set tags or keywords for the metadata.
     * 
     * Example: ['tag1', 'tag2', 'tag3']
     * @param array $tags
     * @return void
     */
    public function setTags(array $tags): void {
        $this->tags = $tags;
    }

    /**
     * Function to get the tags or keywords for the Zenodo record.
     * @return array|null
     */
    public function getTags(): ?array {
        return $this->tags;
    }

    /**
     * Function to set the resource type for the Zenodo record.
     * 
     * Example: 'dataset', 'software', etc.
     * 
     * For publications, it must be in the format 'publication/publication-type'.
     * 
     * Example: 'publication/softwaredocumentation'
     * 
     * For images, it must be in the format 'image/image-type'.
     * 
     * Example: 'image/photo'
     * 
     * For more information, see the Zenodo documentation on their website https://developers.zenodo.org/#representation.
     * @param string $resourceType
     * @return void
     */
    public function setResourceType(string $resourceType): void {
        $this->resourceType = strtolower($resourceType);
    }

    /**
     * Function to get the resource type for the Zenodo record.
     * @return string|null
     */
    public function getResourceType(): ?string {
        return $this->resourceType;
    }

    /**
     * Function to set the date interval for the Zenodo record.
     * 
     * Format should be 'YYYY-MM-DD/YYYY-MM-DD'.
     * 
     * MM and DD are optional.
     * @param string $dateinterval
     * @return void
     */
    public function setDateinterval(string $dateinterval): void {
        $this->dateinterval = $dateinterval;
    }

    /**
     * Function to get the date interval for the Zenodo record.
     * @return string|null
     */
    public function getDateinterval(): ?string {
        return $this->dateinterval;
    }

    /**
     * Function to set the visibility of the resource.
     * 
     * Open access: 'open', Restricted access: 'restricted', Closed access: 'closed'.
     * @param string $visibility
     * @return void
     */
    public function setVisibility(string $visibility): void {
        $this->visibility = $visibility;
    }

    /**
     * Function to get the visibility of the resource.
     * @return string|null
     */
    public function getVisibility(): ?string {
        return $this->visibility;
    }

    /**
     * Function to set the communities for the Zenodo record.
     * 
     * Format should be an array of associative arrays with 'identifier' key.
     * 
     * Example: [['identifier' => 'communityIdentifier1'], ['identifier' => 'communityIdentifier2']]
     * @param array $communities
     * @return void
     */
    public function setCommunities(array $communities): void {
        $this->communities = $communities;
    }

    /**
     * Function to get the communities for the Zenodo record.
     * @return array|null
     */
    public function getCommunities(): ?array {
        return $this->communities;
    }

    /**
     * Function to set the metadata array for the Zenodo record.
     * @return void
     */
    private function setMetadata(): void {

        $publication_type = null;
        $img_type = null;

        if (isset($this->resourceType) ){
            $typelist = explode('/', $this->resourceType) ?: [];
            $trimlist = array_map('trim', $typelist);

        

            if (count($trimlist) > 1) {
                $this->resourceType = $trimlist[0];
                if ($this->resourceType === 'publication') {
                    $publication_type = $trimlist[1];
                } elseif ($this->resourceType === 'image') {
                    $img_type = $trimlist[1];
                }
            }
        }

        $metadata = array_filter([
            'title' => $this->title ?? null,
            'description' => $this->description ?? "No description.",
            'creators' => [['name' => $this->author ?? '', 'affiliation' => $this->organization ?? '']],
            'contributors' => $this->contributors ?? null,
            'keywords' => $this->tags ?? null,
            'upload_type' => $this->resourceType ?? null,
            'publication_type' => $publication_type,
            'image_type' => $img_type,
            'publication_date' => $this->dateinterval ?? null,
            'access_right' => $this->visibility ?? null,
            'communities' => $this->communities ?? null,
            'license' => $this->license ?? null,
        ], function($value) {
            return isset($value);
        });
        $this->metadata = $metadata;
    }

    /**
     * Function to get the metadata array for the Zenodo record.
     * @return array
     */
    public function getMetadata(): array {
        return $this->metadata;
    }

    /**
     * Function to set the file field name for the Zenodo record.
     * @param string $fileFieldName
     * @return void
     */
    public function setFileFieldName(string $fileFieldName): void {
        $this->fileFieldName = $fileFieldName;
    }

    /**
     * Function to get the field name of the uploaded data.
     * 
     * Which is used to identify which file to upload and where to get the file from.
     * @return string|null
     */
    public function getFileFieldName(): ?string {
        return $this->fileFieldName;
    }


    /**
     * Function to set the DOI number for the Zenodo record.
     * @return void
     */
    private function setdoiNumber(): void {
        if (preg_match('/(\d{6})$/', $this->doi, $matches)) {
            $this->doiNumber = $matches[1];
        } else {
            $this->doiNumber = null;
        }
    }

    /**
     * Function to get the DOI number for the Zenodo record.
     * @return string|null
     */
    public function getdoiNumber(): ?string {
        return $this->doiNumber;
    }

    /**
     * Function to set the license for the Zenodo record.
     * 
     * Example: 
     * - cc0-1.0 (Creative Commons Zero)

     * - cc-by-3.0, cc-by-4.0 (Creative Commons Attribution)

     * - cc-by-sa-4.0 (Creative Commons ShareAlike)

     * - cc-by-nc-4.0 (Creative Commons NonCommercial)

     * - mit, gpl-3.0, lgpl-3.0 (common software licenses)
     * @param string $license
     * @return void
     */
    public function setLicense(string $license): void {
        $this->license = $license;
    }

    /**
     * Function to get the license for the Zenodo record.
     * @return string|null
     */
    public function getLicense(): ?string {
        return $this->license;
    }

    /**
     * Function to use when first creating a Zenodo deposition.
     * 
     * It will create a new deposition, upload the file, set the metadata, and publish the deposition to get the DOI.
     * @throws \Exception
     * @return string|null
     */
    public function uploadToZenodo() {

        if (empty($this->zenodoApiKey)) {
            throw new Exception("Zenodo API key is not set.");
        }

        $this->setMetadata();

        $headers = [
            'Content-Type: application/json'
        ];

        // Used to pass the access token in the request
        $params = http_build_query(['access_token' => $this->zenodoApiKey]);

        // 1. Create a new deposition (empty)
        echo "Creating Zenodo deposition...<br>";
        $deposition = $this->createDeposition($headers, $params);

        if (!$deposition || !isset($deposition['id'])) {
            throw new Exception("Failed to create Zenodo deposition.");
        }

        $depositionId = $deposition['id'];

        // 2. Update deposition with metadata
        echo "Updating Zenodo deposition metadata...<br>";
        $metadataUpdated = $this->updateDepositionMetadata($depositionId, $headers, $params);
        if (!$metadataUpdated) {
            throw new Exception("Failed to update Zenodo deposition metadata.");
        }

        // 3. Upload file to the deposition
        echo "Uploading file to Zenodo...<br>";
        $fileUpload = $this->uploadFile($depositionId, $params);
        if (!$fileUpload || isset($fileUpload['error'])) {
            throw new Exception("File upload to Zenodo failed: " . 
                (isset($fileUpload['error']) ? $fileUpload['error'] : "Unknown error"));
        }

        // 4. Publish the deposition
        echo "Publishing Zenodo deposition...<br>";
        $published = $this->publishDeposition($depositionId, $headers, $params);
        if (!$published || !isset($published['doi'])) {
            throw new Exception("Failed to publish deposition or retrieve DOI.");
        }

        $this->doi = $published['doi'];
        $this->setdoiNumber();
        return $this->doi;
    }

    /**
     * Function used to create a new version of an existing Zenodo deposition.
     * @param string $existingDepositionId
     * @throws \Exception
     * @return string|null
     */
    public function createNewZenodoVersion(string $existingDepositionId){
        $headers = [
        'Content-Type: application/json'
        ];

        $params = http_build_query(['access_token' => $this->zenodoApiKey]);

        // First, verify the existing deposition exists and get its current state
        $existingData = $this->checkExistingDeposition($existingDepositionId, $headers, $params);
        
        // Check if the deposition is published
        if ($existingData['state'] !== 'done' && !isset($existingData['published'])) {
            throw new Exception("Cannot create new version: deposition {$existingDepositionId} is not published yet. Current state: {$existingData['state']}. Please publish the existing deposition first.");
        }

        // Step 1: Create a new version of the existing deposition
        $newVersionData = $this->createNewVersion($existingDepositionId, $headers, $params);

        // Extract new deposition ID from latest_draft link
        if (!isset($newVersionData['links']['latest_draft'])) {
            throw new Exception('Invalid response from new version creation - missing latest_draft link');
        }
        
        $newDepositionId = basename($newVersionData['links']['latest_draft']);

        // Step 2: Get the new version deposition details
        $newDepositionData = $this->getDepositionDetails($newDepositionId, $headers, $params);

        // Step 3: Upload new file if provided (optional)
        if (isset($_FILES[$this->fileFieldName]) && !empty($_FILES[$this->fileFieldName]['name'])) {
            $bucketUrl = $newDepositionData['links']['bucket'];
            $this->uploadFileToBucket($bucketUrl, $params);
        }

        // Step 4: Update metadata for the new version
        $this->setMetadata(); // Use existing metadata setup
        $this->updateDepositionMetadata($newDepositionId, $headers, $params);

        // Step 5: Publish the new version
        $published = $this->publishDeposition($newDepositionId, $headers, $params);
        
        if (!$published || !isset($published['doi'])) {
            throw new Exception("Failed to publish new version or retrieve DOI.");
        }

        $this->doi = $published['doi'];
        $this->setdoiNumber();
        return $this->doi;
    }

    /**
     * Function to create a new Zenodo deposition.
     * @param mixed $headers
     * @param mixed $params
     * @throws \Exception
     */
    private function createDeposition($headers, $params) {

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->zenodoApiUrl . '?' . $params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => json_encode((object)[]), // Empty object to create a new deposition
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Check for errors
        if ($response === false) {
            throw new Exception('cURL error: ' . curl_error($curl));
        }

        if ($httpCode >= 400) {
            throw new Exception('HTTP error: ' . $httpCode . ' - ' . $response);
        }

        $responseData = json_decode($response, true);
        return $responseData;
    }

    /**
     * Function to create a new version of an existing Zenodo deposition.
     * @param mixed $depositionId
     * @param mixed $headers
     * @param mixed $params
     * @throws \Exception
     */
    private function createNewVersion($depositionId, $headers, $params) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->zenodoApiUrl . "/{$depositionId}/actions/newversion?" . $params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($response === false) {
            throw new Exception('cURL error: ' . curl_error($curl));
        }

        if ($httpCode >= 400) {
            $errorMessage = "Failed to create new version: {$httpCode} – {$response}";
            
            // More specific error handling
            if ($httpCode === 403) {
                $errorMessage = "Access forbidden for deposition {$depositionId}. This could mean:\n- The deposition doesn't belong to your account\n- The access token lacks permissions\n- The deposition is not published yet";
            } elseif ($httpCode === 404) {
                $errorMessage = "Deposition {$depositionId} not found";
            } elseif ($httpCode === 400) {
                $errorMessage = "Bad request for deposition {$depositionId}: {$response}";
            }
            
            throw new Exception($errorMessage);
        }

        return json_decode($response, true);
    }

    /**
     * Function to upload a file to a Zenodo deposition.
     * @param mixed $depositionId
     * @param mixed $params
     * @throws \Exception
     */
    private function uploadFile($depositionId, $params) {
        $headers = [
            'Content-Type: multipart/form-data'
        ];

        $url = $this->zenodoApiUrl . "/$depositionId/files" . '?' . $params;

        $filename = $_FILES[$this->fileFieldName]['name'];

        // get the file extension
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // the physical file on a temporary uploads directory on the server
        $file = $_FILES[$this->fileFieldName]['tmp_name'];

        // Create CURLFile from the temporary path
        $cfile = new CURLFile($file, $extension, $filename);

        $postFields = [
            'file' => $cfile
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Check for errors
        if ($response === false) {
            throw new Exception('cURL error: ' . curl_error($curl));
        }

        if ($httpCode >= 400) {
            throw new Exception('HTTP error: ' . $httpCode . ' - ' . $response);
        }

        $responseData = json_decode($response, true);
        return $responseData;

    }

    /**
     * Function to update the metadata of a Zenodo deposition.
     * @param mixed $depositionId
     * @param mixed $headers
     * @param mixed $params
     * @throws \Exception
     */
    private function updateDepositionMetadata($depositionId, $headers, $params) {

        $metadata = [
            'metadata' => $this->getMetadata()
        ];

        $url = $this->zenodoApiUrl . "/$depositionId" . '?' . $params;
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => json_encode($metadata),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Check for errors
        if ($response === false) {
            throw new Exception('cURL error: ' . curl_error($curl));
        }

        if ($httpCode >= 400) {
            throw new Exception('HTTP error: ' . $httpCode . ' - ' . $response);
        }

        $responseData = json_decode($response, true);
        return $responseData;
    }

    /**
     * Function to publish a Zenodo deposition.
     * @param mixed $depositionId
     * @param mixed $headers
     * @param mixed $params
     * @throws \Exception
     */
    private function publishDeposition($depositionId, $headers, $params) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->zenodoApiUrl . "/$depositionId/actions/publish" . '?' . $params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Check for errors
        if ($response === false) {
            throw new Exception('cURL error: ' . curl_error($curl));
        }

        if ($httpCode >= 400) {
            throw new Exception('HTTP error: ' . $httpCode . ' - ' . $response);
        }

        $responseData = json_decode($response, true);
        return $responseData;
    }

    /**
     * Function to check if a Zenodo deposition exists.
     * @param mixed $depositionId
     * @param mixed $headers
     * @param mixed $params
     * @throws \Exception
     */
    private function checkExistingDeposition($depositionId, $headers, $params) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->zenodoApiUrl . "/{$depositionId}?" . $params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($response === false) {
            throw new Exception('cURL error: ' . curl_error($curl));
        }

        if ($httpCode >= 400) {
            throw new Exception("Cannot access deposition {$depositionId}: {$httpCode} – {$response}");
        }

        return json_decode($response, true);
    }

    /**
     * Function to get the details of a new version deposition.
     * @param mixed $depositionId
     * @param mixed $headers
     * @param mixed $params
     * @throws \Exception
     */
    private function getDepositionDetails($depositionId, $headers, $params) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->zenodoApiUrl . "/{$depositionId}?" . $params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($response === false) {
            throw new Exception('cURL error: ' . curl_error($curl));
        }

        if ($httpCode >= 400) {
            throw new Exception('Failed to get new version deposition details');
        }

        return json_decode($response, true);
    }

    /**
     * Function to upload a file to a Zenodo bucket.
     * @param mixed $bucketUrl
     * @param mixed $params
     * @throws \Exception
     */
    private function uploadFileToBucket($bucketUrl, $params) {

        $filename = $_FILES[$this->fileFieldName]['name'];
        
        // the physical file on a temporary uploads directory on the server
        $file = $_FILES[$this->fileFieldName]['tmp_name'];
        
        // Read file content for PUT request
        $fileContent = file_get_contents($file);
        if ($fileContent === false) {
            throw new Exception("Failed to read file content");
        }
        
        $uploadUrl = $bucketUrl . '/' . urlencode($filename) . '?' . $params;
        
        $headers = [
            'Content-Type: application/octet-stream',
            'Content-Length: ' . strlen($fileContent)
        ];
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $uploadUrl,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $fileContent, // Raw file content, not CURLFile
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($response === false) {
            throw new Exception('cURL error: ' . curl_error($curl));
        }

        if ($httpCode >= 400) {
            throw new Exception("Upload failed: {$httpCode} – {$response}");
        }

        return json_decode($response, true);
    }


}


