<?php

namespace App\Http\Controllers;

use App\Services\BacNganhService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BacNganhController extends Controller
{
    protected $bacNganhService;

    public function __construct(BacNganhService $bacNganhService)
    {
        $this->bacNganhService = $bacNganhService;
    }

    public function index(): View
    {
        $bacNganhs = $this->bacNganhService->getAll();

        return view('pages.bac-nganh.index', compact('bacNganhs'));
    }

    public function create(): View
    {
        $phanLoaiChoices = $this->bacNganhService->getPhanLoaiChoices();
        return view('pages.bac-nganh.create', compact('phanLoaiChoices'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'ten_khoa_hoc' => 'required|string|max:255',
            'ten_tieng_viet' => 'required|string|max:255',
            'phan_loai' => 'required|string|max:100'
        ], [
            'ten_khoa_hoc.required' => 'Tên khoa học không được để trống',
            'ten_khoa_hoc.max' => 'Tên khoa học không được vượt quá 255 ký tự',
            'ten_tieng_viet.required' => 'Tên tiếng Việt không được để trống',
            'ten_tieng_viet.max' => 'Tên tiếng Việt không được vượt quá 255 ký tự',
            'phan_loai.required' => 'Phân loại không được để trống',
            'phan_loai.max' => 'Phân loại không được vượt quá 100 ký tự'
        ]);

        try {
            $this->bacNganhService->create($request->only(['ten_khoa_hoc', 'ten_tieng_viet', 'phan_loai']));
            return redirect()->route('bac-nganh.index')
                ->with('success', 'Thêm ngành thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }

    public function show(int $id, Request $request): View
    {
        $bacNganh = $this->bacNganhService->findById($id);

        if (!$bacNganh) {
            abort(404, 'Ngành không tồn tại');
        }

        return view('pages.bac-nganh.show', compact('bacNganh'));
    }

    public function edit(int $id): View
    {
        $bacNganh = $this->bacNganhService->findById($id);

        if (!$bacNganh) {
            abort(404, 'Ngành không tồn tại');
        }
        $phanLoaiChoices = $this->bacNganhService->getPhanLoaiChoices();
        return view('pages.bac-nganh.edit', compact('bacNganh', 'phanLoaiChoices'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'ten_khoa_hoc' => 'required|string|max:255',
            'ten_tieng_viet' => 'required|string|max:255',
            'phan_loai' => 'required|string|max:100'
        ], [
            'ten_khoa_hoc.required' => 'Tên khoa học không được để trống',
            'ten_khoa_hoc.max' => 'Tên khoa học không được vượt quá 255 ký tự',
            'ten_tieng_viet.required' => 'Tên tiếng Việt không được để trống',
            'ten_tieng_viet.max' => 'Tên tiếng Việt không được vượt quá 255 ký tự',
            'phan_loai.required' => 'Phân loại không được để trống',
            'phan_loai.max' => 'Phân loại không được vượt quá 100 ký tự'
        ]);

        try {
            $updated = $this->bacNganhService->update($id, $request->only(['ten_khoa_hoc', 'ten_tieng_viet', 'phan_loai']));

            if ($updated) {
                return redirect()->route('bac-nganh.index')
                    ->with('success', 'Cập nhật ngành thành công!');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('err', 'Ngành không tồn tại!');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('err', $e->getMessage());
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            if ($this->bacNganhService->isInUse($id)) {
                return redirect()->route('bac-nganh.index')
                    ->with('err', 'Không thể xóa ngành này vì đang được sử dụng!');
            }

            $deleted = $this->bacNganhService->delete($id);

            if ($deleted) {
                return redirect()->route('bac-nganh.index')
                    ->with('success', 'Xóa ngành thành công!');
            } else {
                return redirect()->route('bac-nganh.index')
                    ->with('err', 'Ngành không tồn tại!');
            }
        } catch (\Exception $e) {
            return redirect()->route('bac-nganh.index')
                ->with('err', $e->getMessage());
        }
    }
}
