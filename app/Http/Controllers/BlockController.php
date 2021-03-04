<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Chapter;
use App\Models\Block;
use App\Models\Category;


class BlockController extends Controller
{
    function addBlock($accout, Category $class, $course_id, $chapter_id, $block_name)
    {
        $chapter  = Chapter::findOrFail($chapter_id);
        // var_dump($chapter_name);die();
        if (isset($block_name)) {
    	$block = Block::create([
                                'block_title'=>$block_name,
                                'chapter_no'=>$chapter->chapter_id,
                                ]);
        }
        
        return redirect()->route('instructor_course_build_all_chapter_blocks', [$class->cat_id, $course_id,$chapter_id]);
    }
    function deleteBlock($accout, Category $class, $course_id, $block_id)
    {
    	$block  = Block::findOrFail($block_id);
    	$chapter_no = $block->chapter_no;
        Block::destroy($block_id);
        
        return redirect()->route('instructor_course_build_all_chapter_blocks', [$class->cat_id, $course_id, $chapter_no]);
    }
    function updateBlockContent($account, Request $request, Category $class, $course_id, $block_id)
    {
    	$block  = Block::findOrFail($block_id);
    	$block->block_content = $request->input("block_content");
    	$chapter_no = $block->chapter_no;
    	$block->save();
        
        return redirect()->route('instructor_course_build_all_chapter_blocks', [$class->cat_id, $course_id, $chapter_no]);
    }
    function allBlocks($accout, Category $class, $course_id, $chapter_id)
    {
        $blocks  = Block::get()->where("chapter_no", $chapter_id)->values();
       
        
        return response()->json( $blocks->toArray() )->header('Content-Type', 'application/json');
    }
}
