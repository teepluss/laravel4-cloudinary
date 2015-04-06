<?php namespace Teepluss\Cloudinary\Test;

use Teepluss\Cloudinary\CloudinaryWrapper;
use Mockery as m;

class CloudinaryWrapperTest extends \PHPUnit_Framework_TestCase
{   
    public function setUp()
    {
        $this->config = m::mock('Illuminate\Config\Repository');
        $this->cloudinary = m::mock('Cloudinary');
        $this->uploader = m::mock('Cloudinary\Uploader');

        $this->config->shouldReceive('get')->once()->with('cloudinary::cloudName')->andReturn('cloudName');
        $this->config->shouldReceive('get')->once()->with('cloudinary::apiKey')->andReturn('apiKey');
        $this->config->shouldReceive('get')->once()->with('cloudinary::apiSecret')->andReturn('apiSecret');

        $this->cloudinary->shouldReceive('config')->once();

        $this->cloudinary_wrapper = new CloudinaryWrapper($this->config, $this->cloudinary, $this->uploader);
    }

    public function tearDown()
    {
        m::close();
    }

    /** @test */
    public function it_should_set_uploaded_result_when_uploading_picture()
    {
        // given
        $filename = 'filename';
        $defaults_options = [
            'public_id' => null,
            'tags'      => array()
        ];

        $expected_result = ['public_id' => '123456789'];

        $this->uploader->shouldReceive('upload')->once()->with($filename, $defaults_options)->andReturn($expected_result);

        // when
        $this->cloudinary_wrapper->upload($filename);

        // then
        $result = $this->cloudinary_wrapper->getResult();
        $this->assertEquals($expected_result, $result);
    }

    /** @test */
    public function it_should_returns_image_url_when_calling_show()
    {
        // given
        $filename = 'filename';
        $this->config->shouldReceive('get')->with('cloudinary::scaling')->once()->andReturn(array());
        $this->cloudinary->shouldReceive('cloudinary_url')->once()->with($filename, array());

        // when
        $this->cloudinary_wrapper->show($filename);
    }

    /** @test */
    public function it_should_call_api_rename_when_calling_rename()
    {
        // given
        $from = 'from';
        $to = 'to';

        $this->uploader->shouldReceive('rename')->with($from, $to, array())->once();

        // when
        $this->cloudinary_wrapper->rename($from, $to);
    }

    /** @test */
    public function it_should_call_api_destroy_when_calling_destroy_image()
    {
        // given
        $pid = 'pid';
        $this->uploader->shouldReceive('destroy')->with($pid, array())->once();

        // when
        $this->cloudinary_wrapper->destroyImage($pid);
    }

    /** @test */
    public function it_should_call_api_destroy_with_array_of_public_ids()
    {
        // given
        $pids = ['pid1', 'pid2'];
        $this->uploader->shouldReceive('destroy')->with($pids, array())->once();

        // when
        $this->cloudinary_wrapper->destroyImages($pids);
    }

    /** @test */
    public function verify_delete_alias()
    {
        // given
        $pid = 'pid';
        $this->uploader->shouldReceive('destroy')->with($pid, array())->once();

        // when
        $this->cloudinary_wrapper->delete($pid);
    }

    /** @test */
    public function it_should_call_api_add_tag_when_calling_add_tag()
    {
        $pids = ['pid1', 'pid2'];
        $tag = 'tag';

        $this->uploader->shouldReceive('add_tag')->once()->with($tag, $pids, array());

        $this->cloudinary_wrapper->addTag($tag, $pids);
    }

    /** @test */
    public function it_should_call_api_remove_tag_when_calling_add_tag()
    {
        $pids = ['pid1', 'pid2'];
        $tag = 'tag';

        $this->uploader->shouldReceive('remove_tag')->once()->with($tag, $pids, array());

        $this->cloudinary_wrapper->removeTag($tag, $pids);
    }

        /** @test */
    public function it_should_call_api_rename_tag_when_calling_add_tag()
    {
        $pids = ['pid1', 'pid2'];
        $tag = 'tag';

        $this->uploader->shouldReceive('replace_tag')->once()->with($tag, $pids, array());

        $this->cloudinary_wrapper->replaceTag($tag, $pids);
    }
}