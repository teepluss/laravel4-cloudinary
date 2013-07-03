<?php namespace Teepluss\Cloudinary;

use Cloudinary;
use Illuminate\Config\Repository;

class CloudinaryWrapper {

    /**
     * Cloudinary lib.
     *
     * @var \Cloudinary
     */
    protected $cloudinary;

    /**
     * Cloudinary uploader.
     *
     * @var \Cloudinary\Uplaoder
     */
    protected $uploader;

    /**
     * Repository config.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    protected $uploadedResult;

    /**
     * Create a new cloudinary instance.
     *
     * @param  \Illuminate\Config\Repository $config
     * @return void
     */
    public function __construct(Repository $config)
    {
        $this->cloudinary = new Cloudinary;

        $this->uploader = new Cloudinary\Uploader;

        $this->config = $config;

        $this->cloudinary->config(array(
            'cloud_name' => $this->config->get('cloudinary::cloudName'),
            'api_key'    => $this->config->get('cloudinary::apiKey'),
            'api_secret' => $this->config->get('cloudinary::apiSecret')
        ));
    }

    public function getCloudinary()
    {
        return $this->cloudinary;
    }

    public function getUploader()
    {
        return $this->uploader;
    }

    public function upload($source, $publicId, $tags = array())
    {
        $defaults = array(
            'public_id' => null,
            'tags'      => array()
        );

        $options = array_merge($defaults, array(
            'public_id' => $publicId,
            'tags'      => $tags
        ));

        $this->uploadedResult = $this->getUploader()->upload($source, $options);

        return $this;
    }

    public function getResult()
    {
        return $this->uploadedResult;
    }

    public function getPublicId()
    {
        return $this->uploadedResult['public_id'];
    }

    public function show($publicId, $options = array())
    {
        $defaults = $this->config->get('cloudinary::scaling');

        $options = array_merge($defaults, $options);

        return $this->getCloudinary()->cloudinary_url($publicId, $options);
    }

    public function rename($publicId, $toPublicId, $options = array())
    {
        try
        {
            return $this->getUploader()->rename($publicId, $toPublicId, $options);
        }
        catch (\Exception $e) { }

        return false;
    }

    public function destroy($publicId, $options = array())
    {
        return $this->getUploader()->destroy($publicId, $options);
    }

    public function delete($publicId, $options = array())
    {
        $response = $this->destroy($publicId, $options);

        return (boolean) ($response['result'] == 'ok');
    }

    public function addTag($tag, $publicIds = array(), $options = array())
    {
        return $this->getUploader()->add_tag($tag, $publicIds, $options);
    }

    public function removeTag($tag, $publicIds = array(), $options = array())
    {
        return $this->getUploader()->remove_tag($tag, $publicIds, $options);
    }

    public function replaceTag($tag, $publicIds = array(), $options = array())
    {
        return $this->getUploader()->replace_tag($tag, $publicIds, $options);
    }

}