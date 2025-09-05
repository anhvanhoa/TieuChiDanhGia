<?php

namespace App\Http\Controllers;

use App\Services\BacHoService;
use App\Services\BacBoService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BacHoController extends Controller
{
    protected $bacHoService;
    protected $bacBoService;

    public function __construct(BacHoService $bacHoService, BacBoService $bacBoService)
    {
        $this->bacHoService = $bacHoService;
        $this->bacBoService = $bacBoService;
    }

    public function index(): View
    {
        $bacHos = $this->bacHoService->getAll();

        return view('pages.bac-ho.index', compact('bacHos'));
    }

    public function create(): View
    {
        $bacBos = $this->bacBoService->getAll();

        return view('pages.bac-ho.create', compact('bacBos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'bac_bo_id' => 'required|exists:bac_bo,id',
            'ten_khoa_hoc' => 'required|string|max:255',
            'ten_tieng_viet' => 'required|string|max:255'
        ], [
            'bac_bo_id.required' => 'Bộ không được để trống',
            'bac_bo_id.exists' => 'Bộ không tồn tại',
            'ten_khoa_hoc.required' => 'Tên khoa học không được để trống',
            'ten_khoa_hoc.max' => 'Tên khoa học không được vượt quá 255 ký tự',
            'ten_tieng_viet.required' => 'Tên tiếng Việt không được để trống',
            'ten_tieng_viet.max' => 'Tên tiếng Việt không được vượt quá 255 ký tự'
        ]);

        try {
            $this->bacHoService->create($request->only(['bac_bo_id', 'ten_khoa_hoc', 'ten_tieng_viet']));
            return redirect()->route('bac-ho.index')
                ->with('success', 'Thêm họ thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }

    public function show(int $id, Request $request): View
    {
        $bacHo = $this->bacHoService->findById($id);

        if (!$bacHo) {
            abort(404, 'Họ không tồn tại');
        }

        return view('pages.bac-ho.show', compact('bacHo'));
    }

    public function edit(int $id): View
    {
        $bacHo = $this->bacHoService->findById($id);
        $bacBos = $this->bacBoService->getAll();

        if (!$bacHo) {
            abort(404, 'Họ không tồn tại');
        }

        return view('pages.bac-ho.edit', compact('bacHo', 'bacBos'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'bac_bo_id' => 'required|exists:bac_bo,id',
            'ten_khoa_hoc' => 'required|string|max:255',
            'ten_tieng_viet' => 'required|string|max:255'
        ], [
            'bac_bo_id.required' => 'Bộ không được để trống',
            'bac_bo_id.exists' => 'Bộ không tồn tại',
            'ten_khoa_hoc.required' => 'Tên khoa học không được để trống',
            'ten_khoa_hoc.max' => 'Tên khoa học không được vượt quá 255 ký tự',
            'ten_tieng_viet.required' => 'Tên tiếng Việt không được để trống',
            'ten_tieng_viet.max' => 'Tên tiếng Việt không được vượt quá 255 ký tự'
        ]);

        try {
            $updated = $this->bacHoService->update($id, $request->only(['bac_bo_id', 'ten_khoa_hoc', 'ten_tieng_viet']));

            if ($updated) {
                return redirect()->route('bac-ho.index')
                    ->with('success', 'Cập nhật họ thành công!');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('err', 'Họ không tồn tại!');
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
            if ($this->bacHoService->isInUse($id)) {
                return redirect()->route('bac-ho.index')
                    ->with('err', 'Không thể xóa họ này vì đang được sử dụng!');
            }

            $deleted = $this->bacHoService->delete($id);

            if ($deleted) {
                return redirect()->route('bac-ho.index')
                    ->with('success', 'Xóa họ thành công!');
            } else {
                return redirect()->route('bac-ho.index')
                    ->with('err', 'Họ không tồn tại!');
            }
        } catch (\Exception $e) {
            return redirect()->route('bac-ho.index')
                ->with('err', $e->getMessage());
        }
    }
}
