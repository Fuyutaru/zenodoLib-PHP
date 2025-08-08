<?php
include "../zenodophp.php";


// Uploads files
if (isset($_POST['save'])) { // if save button on the form is clicked


    $zenodoUploader = new ZenodoUploader(true);

    $zenodoUploader->setFileFieldName('myfile');
    $zenodoUploader->setZenodoApiKey($_POST['apikey']);
    $zenodoUploader->setTitle($_POST['title']);
    $zenodoUploader->setDescription($_POST['description']);
    $zenodoUploader->setAuthor($_POST['authors']);
    $zenodoUploader->setVisibility('open');
    $zenodoUploader->setResourceType('Image/Plot');
    $zenodoUploader->setOrganization('geoecomar'); 

    $zenodoUploader->setContributors([
        [
            'name' => 'jon, doe',
            'type' => 'Editor'
        ],
        [
            'name' => 'oda, fsa',
            'type' => 'Supervisor',
        ]
    ]);

    $zenodoUploader->setTags([
        'tag1',
        'tag2',
        'tag3'
    ]);

    $zenodoUploader->setDateinterval('2023-01-01/2023-12-31');

    $zenodoUploader->setCommunities([
        ['identifier' => 'ssss']
    ]);
    

    try {
        $doi = $zenodoUploader->uploadToZenodo();
        echo "Zenodo DOI generated: " . $doi;
    } catch (Exception $e) {
        echo "Zenodo upload failed: " . $e->getMessage();
        $doi = "Upload failed";
    }


    // test new version

    $zenodoUploader->setVisibility('closed');
    $zenodoUploader->setResourceType('Publication/Book');
    $zenodoUploader->setOrganization('geoecomar'); 

    $zenodoUploader->setContributors([
        [
            'name' => 'jon, doe',
            'type' => 'Editor'
        ],
        [
            'name' => 'oda, nobunaga',
            'type' => 'ProjectLeader',
        ]
    ]);

    $zenodoUploader->setTags([
        'tag1',
        'new',
        'license'
    ]);

    $zenodoUploader->setLicense('cc-by-sa-4.0');

    $zenodoUploader->createNewZenodoVersion($zenodoUploader->getdoiNumber());


}


