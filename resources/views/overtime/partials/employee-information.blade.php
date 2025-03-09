<div class="employee-information px-5 py-4 msb-3">
    <h4 class="fw-bold" style="color: #4343FF">Employee Information</h4>
    <div>
        <table class="table-bordered w-100">
            <tr>
                <td class="p-3">
                    <strong>{{ Auth::user()->name }}</strong>
                    <div class="px-2 py-1 rounded mt-3" style="background-color: #F3F3FF; color: #4343FF">NIP :
                        {{ Auth::user()->userProfile->nip }}</div>
                </td>
                <td class="p-3">
                    <div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <span><small>Position</small></span><br>
                                {{ Auth::user()->userProfile->position }}
                            </div>
                            <div>
                                <span><small>Departement</small></span><br>
                                {{ Auth::user()->department }}
                            </div>
                        </div>
                    </div>
                </td>
                @isset(Auth::user()->supervisor)
                    <td class="p-3">
                        <div>
                            <small>Direct HR</small><br>
                            {{ Auth::user()->supervisor->name }}
                        </div>
                    </td>
                @endisset
                <td class="p-3">
                    <div>
                        <small>Join Date</small><br>
                        {{ date('d-F-Y', strtotime(Auth::user()->userProfile->join_date)) }}
                    </div>
                </td>
                <td class="p-3">
                    <div>
                        <small>Status</small><br>
                        {{ Auth::user()->userProfile->status }}
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
