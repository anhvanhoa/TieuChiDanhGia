<?php

namespace App\Http\Controllers;

use App\Services\LoaiVuonQuocGiaService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoaiVuonQuocGiaController extends Controller
{
    protected $loaiVuonQuocGiaService;

    public function __construct(LoaiVuonQuocGiaService $loaiVuonQuocGiaService)
    {
        $this->loaiVuonQuocGiaService = $loaiVuonQuocGiaService;
    }

    public function index(): View
    {
        $loaiVuonQuocGias = $this->loaiVuonQuocGiaService->getAll();

        return view('pages.loai-vuon-quoc-gia.index', compact('loaiVuonQuocGias'));
    }

    public function create(): View
    {
        return view('pages.loai-vuon-quoc-gia.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'ten_loai' => 'required|string|max:255|unique:loai_vuon_quoc_gia,ten_loai'
        ], [
            'ten_loai.required' => 'Tên loại vườn quốc gia không được để trống',
            'ten_loai.unique' => 'Tên loại vườn quốc gia đã tồn tại',
            'ten_loai.max' => 'Tên loại vườn quốc gia không được vượt quá 255 ký tự'
        ]);

        try {
            $this->loaiVuonQuocGiaService->create($request->only('ten_loai'));
            return redirect()->route('loai-vuon-quoc-gia.index')
                ->with('success', 'Thêm loại vườn quốc gia thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err', 'Có lỗi xảy ra khi thêm loại vườn quốc gia!');
        }
    }

    public function show(int $id, Request $request): View
    {
        $loaiVuonQuocGia = $this->loaiVuonQuocGiaService->findById($id);

        if (!$loaiVuonQuocGia) {
            abort(404, 'Loại vườn quốc gia không tồn tại');
        }

        return view('pages.loai-vuon-quoc-gia.show', compact('loaiVuonQuocGia'));
    }

    public function edit(int $id): View
    {
        $loaiVuonQuocGia = $this->loaiVuonQuocGiaService->findById($id);

        if (!$loaiVuonQuocGia) {
            abort(404, 'Loại vườn quốc gia không tồn tại');
        }

        return view('pages.loai-vuon-quoc-gia.edit', compact('loaiVuonQuocGia'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'ten_loai' => 'required|string|max:255|unique:loai_vuon_quoc_gia,ten_loai,' . $id
        ], [
            'ten_loai.required' => 'Tên loại vườn quốc gia không được để trống',
            'ten_loai.unique' => 'Tên loại vườn quốc gia đã tồn tại',
            'ten_loai.max' => 'Tên loại vườn quốc gia không được vượt quá 255 ký tự'
        ]);

        try {
            $updated = $this->loaiVuonQuocGiaService->update($id, $request->only('ten_loai'));

            if ($updated) {
                return redirect()->route('loai-vuon-quoc-gia.index')
                    ->with('success', 'Cập nhật loại vườn quốc gia thành công!');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('err', 'Loại vườn quốc gia không tồn tại!');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('err', 'Có lỗi xảy ra khi cập nhật loại vườn quốc gia!');
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            if ($this->loaiVuonQuocGiaService->isInUse($id)) {
                return redirect()->route('loai-vuon-quoc-gia.index')
                    ->with('err', 'Không thể xóa loại vườn quốc gia này vì đang được sử dụng!');
            }

            $deleted = $this->loaiVuonQuocGiaService->delete($id);

            if ($deleted) {
                return redirect()->route('loai-vuon-quoc-gia.index')
                    ->with('success', 'Xóa loại vườn quốc gia thành công!');
            } else {
                return redirect()->route('loai-vuon-quoc-gia.index')
                    ->with('err', 'Loại vườn quốc gia không tồn tại!');
            }
        } catch (\Exception $e) {
            return redirect()->route('loai-vuon-quoc-gia.index')
                ->with('err', 'Có lỗi xảy ra khi xóa loại vườn quốc gia!');
        }
    }
}
