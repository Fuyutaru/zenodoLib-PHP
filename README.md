
# Zenodo PHP Library

This library allows you to upload files and metadata to [Zenodo](https://zenodo.org/) using PHP.

## Features

- Upload files to Zenodo (sandbox or production)
- Set metadata: title, description, authors, tags, contributors, organization, resource type, communities, license, and more
- Create new versions of existing Zenodo records

## Installation

1. Clone or download this repository.
2. Place `zenodophp.php` in your project directory.

## Usage

### 1. Include the Library

```php
require_once 'zenodophp.php';
```

### 2. Create the Uploader

```php
$zenodoUploader = new ZenodoUploader(true); // true = sandbox, false = production
```

### 3. Set Metadata and File

```php
$zenodoUploader->setFileFieldName('myfile'); // Name of the file input field
$zenodoUploader->setZenodoApiKey('YOUR_API_KEY');
$zenodoUploader->setTitle('Your Title');
$zenodoUploader->setDescription('Description of your upload');
$zenodoUploader->setAuthor('First Last');
$zenodoUploader->setVisibility('open');
$zenodoUploader->setResourceType('Image/Plot');
$zenodoUploader->setOrganization('Your Organization');
$zenodoUploader->setContributors([
	['name' => 'John, Doe', 'type' => 'Editor']
]);
$zenodoUploader->setTags(['tag1', 'tag2']);
$zenodoUploader->setDateinterval('2023-01-01/2023-12-31');
$zenodoUploader->setCommunities([['identifier' => 'yourcommunity']]);
$zenodoUploader->setLicense('cc-by-4.0');
```

### 4. Upload

```php
try {
	$doi = $zenodoUploader->uploadToZenodo();
	echo "Zenodo DOI generated: " . $doi;
} catch (Exception $e) {
	echo "Zenodo upload failed: " . $e->getMessage();
}
```

### 5. Create a New Version

```php
$zenodoUploader->createNewZenodoVersion($zenodoUploader->getdoiNumber());
```


## Notes

- **Mandatory fields for first upload:**
	- File (uploaded via the file input field)
	- API key
	- Title
	- Author
	- Resource type
- You need a Zenodo API key. Get one from your Zenodo account settings.
- For testing, use the sandbox (`new ZenodoUploader(true)`).
- For production, use `new ZenodoUploader(false)`.

## Example

See `Example/Test.php` for a full example of how to use the library.
