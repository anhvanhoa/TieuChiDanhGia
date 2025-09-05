<?php

namespace App\Http\Controllers;

use App\Services\VuonQuocGiaService;
use App\Services\LoaiVuonQuocGiaService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VuonQuocGiaController extends Controller
{
    protected $vuonQuocGiaService;
    protected $loaiVuonQuocGiaService;

    public function __construct(VuonQuocGiaService $vuonQuocGiaService, LoaiVuonQuocGiaService $loaiVuonQuocGiaService)
    {
        $this->vuonQuocGiaService = $vuonQuocGiaService;
        $this->loaiVuonQuocGiaService = $loaiVuonQuocGiaService;
    }

    public function index(): View
    {
        $vuonQuocGias = $this->vuonQuocGiaService->getAll();
        $statistics = $this->vuonQuocGiaService->getStatistics();

        return view('pages.vuon-quoc-gia.index', compact('vuonQuocGias', 'statistics'));
    }

    public function create(): View
    {
        $loaiVuonQuocGias = $this->loaiVuonQuocGiaService->getAll();

        return view('pages.vuon-quoc-gia.create', compact('loaiVuonQuocGias'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'ten_vuon' => 'required|string|max:255',
            'dia_chi' => 'required|string|max:500',
            'ngay_thanh_lap' => 'required|date',
            'loai_vuon_quoc_gia_id' => 'required|exists:loai_vuon_quoc_gia,id'
        ], [
            'ten_vuon.required' => 'Tên vườn quốc gia không được để trống',
            'ten_vuon.max' => 'Tên vườn quốc gia không được vượt quá 255 ký tự',
            'dia_chi.required' => 'Địa chỉ không được để trống',
            'dia_chi.max' => 'Địa chỉ không được vượt quá 500 ký tự',
            'ngay_thanh_lap.required' => 'Ngày thành lập không được để trống',
            'ngay_thanh_lap.date' => 'Ngày thành lập phải là định dạng ngày hợp lệ',
            'loai_vuon_quoc_gia_id.required' => 'Loại vườn quốc gia không được để trống',
            'loai_vuon_quoc_gia_id.exists' => 'Loại vườn quốc gia không tồn tại'
        ]);

        try {
            $this->vuonQuocGiaService->create($request->only(['ten_vuon', 'dia_chi', 'ngay_thanh_lap', 'loai_vuon_quoc_gia_id']));
            return redirect()->route('vuon-quoc-gia.index')
                ->with('success', 'Thêm vườn quốc gia thành công!');
        } catch (\Exception $e) {
            // return redirect()->back()->withInput()->with('err', 'Có lỗi xảy ra khi thêm vườn quốc gia!');
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }

    public function show(int $id, Request $request): View
    {
        $vuonQuocGia = $this->vuonQuocGiaService->findById($id);

        if (!$vuonQuocGia) {
            abort(404, 'Vườn quốc gia không tồn tại');
        }

        return view('pages.vuon-quoc-gia.show', compact('vuonQuocGia'));
    }

    public function edit(int $id): View
    {
        $vuonQuocGia = $this->vuonQuocGiaService->findById($id);
        $loaiVuonQuocGias = $this->loaiVuonQuocGiaService->getAll();

        if (!$vuonQuocGia) {
            abort(404, 'Vườn quốc gia không tồn tại');
        }

        return view('pages.vuon-quoc-gia.edit', compact('vuonQuocGia', 'loaiVuonQuocGias'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'ten_vuon' => 'required|string|max:255',
            'dia_chi' => 'required|string|max:500',
            'ngay_thanh_lap' => 'required|date',
            'loai_vuon_quoc_gia_id' => 'required|exists:loai_vuon_quoc_gia,id'
        ], [
            'ten_vuon.required' => 'Tên vườn quốc gia không được để trống',
            'ten_vuon.max' => 'Tên vườn quốc gia không được vượt quá 255 ký tự',
            'dia_chi.required' => 'Địa chỉ không được để trống',
            'dia_chi.max' => 'Địa chỉ không được vượt quá 500 ký tự',
            'ngay_thanh_lap.required' => 'Ngày thành lập không được để trống',
            'ngay_thanh_lap.date' => 'Ngày thành lập phải là định dạng ngày hợp lệ',
            'loai_vuon_quoc_gia_id.required' => 'Loại vườn quốc gia không được để trống',
            'loai_vuon_quoc_gia_id.exists' => 'Loại vườn quốc gia không tồn tại'
        ]);

        try {
            $updated = $this->vuonQuocGiaService->update($id, $request->only(['ten_vuon', 'dia_chi', 'ngay_thanh_lap', 'loai_vuon_quoc_gia_id']));

            if ($updated) {
                return redirect()->route('vuon-quoc-gia.index')
                    ->with('success', 'Cập nhật vườn quốc gia thành công!');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('err', 'Vườn quốc gia không tồn tại!');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('err', 'Có lỗi xảy ra khi cập nhật vườn quốc gia!');
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            if ($this->vuonQuocGiaService->isInUse($id)) {
                return redirect()->route('vuon-quoc-gia.index')
                    ->with('err', 'Không thể xóa vườn quốc gia này vì đang được sử dụng!');
            }

            $deleted = $this->vuonQuocGiaService->delete($id);

            if ($deleted) {
                return redirect()->route('vuon-quoc-gia.index')
                    ->with('success', 'Xóa vườn quốc gia thành công!');
            } else {
                return redirect()->route('vuon-quoc-gia.index')
                    ->with('err', 'Vườn quốc gia không tồn tại!');
            }
        } catch (\Exception $e) {
            return redirect()->route('vuon-quoc-gia.index')
                ->with('err', 'Có lỗi xảy ra khi xóa vườn quốc gia!');
        }
    }
}
