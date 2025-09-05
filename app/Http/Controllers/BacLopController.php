<?php

namespace App\Http\Controllers;

use App\Services\BacLopService;
use App\Services\BacNganhService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BacLopController extends Controller
{
    protected $bacLopService;
    protected $bacNganhService;

    public function __construct(BacLopService $bacLopService, BacNganhService $bacNganhService)
    {
        $this->bacLopService = $bacLopService;
        $this->bacNganhService = $bacNganhService;
    }

    public function index(): View
    {
        $bacLops = $this->bacLopService->getAll();

        return view('pages.bac-lop.index', compact('bacLops'));
    }

    public function create(): View
    {
        $bacNganhs = $this->bacNganhService->getAll();

        return view('pages.bac-lop.create', compact('bacNganhs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'bac_nganh_id' => 'required|exists:bac_nganh,id',
            'ten_khoa_hoc' => 'required|string|max:255',
            'ten_tieng_viet' => 'required|string|max:255'
        ], [
            'bac_nganh_id.required' => 'Ngành không được để trống',
            'bac_nganh_id.exists' => 'Ngành không tồn tại',
            'ten_khoa_hoc.required' => 'Tên khoa học không được để trống',
            'ten_khoa_hoc.max' => 'Tên khoa học không được vượt quá 255 ký tự',
            'ten_tieng_viet.required' => 'Tên tiếng Việt không được để trống',
            'ten_tieng_viet.max' => 'Tên tiếng Việt không được vượt quá 255 ký tự'
        ]);

        try {
            $this->bacLopService->create($request->only(['bac_nganh_id', 'ten_khoa_hoc', 'ten_tieng_viet']));
            return redirect()->route('bac-lop.index')
                ->with('success', 'Thêm lớp thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }

    public function show(int $id, Request $request): View
    {
        $bacLop = $this->bacLopService->findById($id);

        if (!$bacLop) {
            abort(404, 'Lớp không tồn tại');
        }

        return view('pages.bac-lop.show', compact('bacLop'));
    }

    public function edit(int $id): View
    {
        $bacLop = $this->bacLopService->findById($id);
        $bacNganhs = $this->bacNganhService->getAll();

        if (!$bacLop) {
            abort(404, 'Lớp không tồn tại');
        }

        return view('pages.bac-lop.edit', compact('bacLop', 'bacNganhs'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'bac_nganh_id' => 'required|exists:bac_nganh,id',
            'ten_khoa_hoc' => 'required|string|max:255',
            'ten_tieng_viet' => 'required|string|max:255'
        ], [
            'bac_nganh_id.required' => 'Ngành không được để trống',
            'bac_nganh_id.exists' => 'Ngành không tồn tại',
            'ten_khoa_hoc.required' => 'Tên khoa học không được để trống',
            'ten_khoa_hoc.max' => 'Tên khoa học không được vượt quá 255 ký tự',
            'ten_tieng_viet.required' => 'Tên tiếng Việt không được để trống',
            'ten_tieng_viet.max' => 'Tên tiếng Việt không được vượt quá 255 ký tự'
        ]);

        try {
            $updated = $this->bacLopService->update($id, $request->only(['bac_nganh_id', 'ten_khoa_hoc', 'ten_tieng_viet']));

            if ($updated) {
                return redirect()->route('bac-lop.index')
                    ->with('success', 'Cập nhật lớp thành công!');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('err', 'Lớp không tồn tại!');
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
            if ($this->bacLopService->isInUse($id)) {
                return redirect()->route('bac-lop.index')
                    ->with('err', 'Không thể xóa lớp này vì đang được sử dụng!');
            }

            $deleted = $this->bacLopService->delete($id);

            if ($deleted) {
                return redirect()->route('bac-lop.index')
                    ->with('success', 'Xóa lớp thành công!');
            } else {
                return redirect()->route('bac-lop.index')
                    ->with('err', 'Lớp không tồn tại!');
            }
        } catch (\Exception $e) {
            return redirect()->route('bac-lop.index')
                ->with('err', $e->getMessage());
        }
    }
}
