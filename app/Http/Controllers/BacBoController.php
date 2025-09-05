<?php

namespace App\Http\Controllers;

use App\Services\BacBoService;
use App\Services\BacLopService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BacBoController extends Controller
{
    protected $bacBoService;
    protected $bacLopService;

    public function __construct(BacBoService $bacBoService, BacLopService $bacLopService)
    {
        $this->bacBoService = $bacBoService;
        $this->bacLopService = $bacLopService;
    }

    public function index(): View
    {
        $bacBos = $this->bacBoService->getAll();

        return view('pages.bac-bo.index', compact('bacBos'));
    }

    public function create(): View
    {
        $bacLops = $this->bacLopService->getAll();

        return view('pages.bac-bo.create', compact('bacLops'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'bac_lop_id' => 'required|exists:bac_lop,id',
            'ten_khoa_hoc' => 'required|string|max:255',
            'ten_tieng_viet' => 'required|string|max:255'
        ], [
            'bac_lop_id.required' => 'Lớp không được để trống',
            'bac_lop_id.exists' => 'Lớp không tồn tại',
            'ten_khoa_hoc.required' => 'Tên khoa học không được để trống',
            'ten_khoa_hoc.max' => 'Tên khoa học không được vượt quá 255 ký tự',
            'ten_tieng_viet.required' => 'Tên tiếng Việt không được để trống',
            'ten_tieng_viet.max' => 'Tên tiếng Việt không được vượt quá 255 ký tự'
        ]);

        try {
            $this->bacBoService->create($request->only(['bac_lop_id', 'ten_khoa_hoc', 'ten_tieng_viet']));
            return redirect()->route('bac-bo.index')
                ->with('success', 'Thêm bộ thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }

    public function show(int $id, Request $request): View
    {
        $bacBo = $this->bacBoService->findById($id);

        if (!$bacBo) {
            abort(404, 'Bộ không tồn tại');
        }

        return view('pages.bac-bo.show', compact('bacBo'));
    }

    public function edit(int $id): View
    {
        $bacBo = $this->bacBoService->findById($id);
        $bacLops = $this->bacLopService->getAll();

        if (!$bacBo) {
            abort(404, 'Bộ không tồn tại');
        }

        return view('pages.bac-bo.edit', compact('bacBo', 'bacLops'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'bac_lop_id' => 'required|exists:bac_lop,id',
            'ten_khoa_hoc' => 'required|string|max:255',
            'ten_tieng_viet' => 'required|string|max:255'
        ], [
            'bac_lop_id.required' => 'Lớp không được để trống',
            'bac_lop_id.exists' => 'Lớp không tồn tại',
            'ten_khoa_hoc.required' => 'Tên khoa học không được để trống',
            'ten_khoa_hoc.max' => 'Tên khoa học không được vượt quá 255 ký tự',
            'ten_tieng_viet.required' => 'Tên tiếng Việt không được để trống',
            'ten_tieng_viet.max' => 'Tên tiếng Việt không được vượt quá 255 ký tự'
        ]);

        try {
            $updated = $this->bacBoService->update($id, $request->only(['bac_lop_id', 'ten_khoa_hoc', 'ten_tieng_viet']));

            if ($updated) {
                return redirect()->route('bac-bo.index')
                    ->with('success', 'Cập nhật bộ thành công!');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('err', 'Bộ không tồn tại!');
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
            if ($this->bacBoService->isInUse($id)) {
                return redirect()->route('bac-bo.index')
                    ->with('err', 'Không thể xóa bộ này vì đang được sử dụng!');
            }

            $deleted = $this->bacBoService->delete($id);

            if ($deleted) {
                return redirect()->route('bac-bo.index')
                    ->with('success', 'Xóa bộ thành công!');
            } else {
                return redirect()->route('bac-bo.index')
                    ->with('err', 'Bộ không tồn tại!');
            }
        } catch (\Exception $e) {
            return redirect()->route('bac-bo.index')
                ->with('err', $e->getMessage());
        }
    }
}
