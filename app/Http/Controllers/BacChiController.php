<?php

namespace App\Http\Controllers;

use App\Services\BacChiService;
use App\Services\BacHoService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BacChiController extends Controller
{
    protected $bacChiService;
    protected $bacHoService;

    public function __construct(BacChiService $bacChiService, BacHoService $bacHoService)
    {
        $this->bacChiService = $bacChiService;
        $this->bacHoService = $bacHoService;
    }

    public function index(): View
    {
        $bacChis = $this->bacChiService->getAll();

        return view('pages.bac-chi.index', compact('bacChis'));
    }

    public function create(): View
    {
        $bacHos = $this->bacHoService->getAll();

        return view('pages.bac-chi.create', compact('bacHos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'bac_ho_id' => 'required|exists:bac_ho,id',
            'ten_khoa_hoc' => 'required|string|max:255',
            'ten_tieng_viet' => 'required|string|max:255'
        ], [
            'bac_ho_id.required' => 'Họ không được để trống',
            'bac_ho_id.exists' => 'Họ không tồn tại',
            'ten_khoa_hoc.required' => 'Tên khoa học không được để trống',
            'ten_khoa_hoc.max' => 'Tên khoa học không được vượt quá 255 ký tự',
            'ten_tieng_viet.required' => 'Tên tiếng Việt không được để trống',
            'ten_tieng_viet.max' => 'Tên tiếng Việt không được vượt quá 255 ký tự'
        ]);

        try {
            $this->bacChiService->create($request->only(['bac_ho_id', 'ten_khoa_hoc', 'ten_tieng_viet']));
            return redirect()->route('bac-chi.index')
                ->with('success', 'Thêm chi thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }

    public function show(int $id, Request $request): View
    {
        $bacChi = $this->bacChiService->findById($id);

        if (!$bacChi) {
            abort(404, 'Chi không tồn tại');
        }

        return view('pages.bac-chi.show', compact('bacChi'));
    }

    public function edit(int $id): View
    {
        $bacChi = $this->bacChiService->findById($id);
        $bacHos = $this->bacHoService->getAll();

        if (!$bacChi) {
            abort(404, 'Chi không tồn tại');
        }

        return view('pages.bac-chi.edit', compact('bacChi', 'bacHos'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'bac_ho_id' => 'required|exists:bac_ho,id',
            'ten_khoa_hoc' => 'required|string|max:255',
            'ten_tieng_viet' => 'required|string|max:255'
        ], [
            'bac_ho_id.required' => 'Họ không được để trống',
            'bac_ho_id.exists' => 'Họ không tồn tại',
            'ten_khoa_hoc.required' => 'Tên khoa học không được để trống',
            'ten_khoa_hoc.max' => 'Tên khoa học không được vượt quá 255 ký tự',
            'ten_tieng_viet.required' => 'Tên tiếng Việt không được để trống',
            'ten_tieng_viet.max' => 'Tên tiếng Việt không được vượt quá 255 ký tự'
        ]);

        try {
            $updated = $this->bacChiService->update($id, $request->only(['bac_ho_id', 'ten_khoa_hoc', 'ten_tieng_viet']));

            if ($updated) {
                return redirect()->route('bac-chi.index')
                    ->with('success', 'Cập nhật chi thành công!');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('err', 'Chi không tồn tại!');
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
            if ($this->bacChiService->isInUse($id)) {
                return redirect()->route('bac-chi.index')
                    ->with('err', 'Không thể xóa chi này vì đang được sử dụng!');
            }

            $deleted = $this->bacChiService->delete($id);

            if ($deleted) {
                return redirect()->route('bac-chi.index')
                    ->with('success', 'Xóa chi thành công!');
            } else {
                return redirect()->route('bac-chi.index')
                    ->with('err', 'Chi không tồn tại!');
            }
        } catch (\Exception $e) {
            return redirect()->route('bac-chi.index')
                ->with('err', $e->getMessage());
        }
    }
}
