<?php
/* Copyright 2012 BrewPi/Elco Jacobs.
 * This file is part of BrewPi.

 * BrewPi is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * BrewPi is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with BrewPi.  If not, see <http://www.gnu.org/licenses/>.
 */

function echoFilterSelect($filterName){
	echo "<select name=" . $filterName . " class=\"cc " . $filterName . "\">";
	// These values assume a sample frequency of 1 hz and 3 cascaded filters. Delay time below is in nr of samples for a single section
	echo "<option value=0>   9 seconds</option>"; // a=4,	b=0,	delay time = 3
	echo "<option value=1>  18 seconds</option>"; // a=6,	b=1,	delay time = 6
	echo "<option value=2>  39 seconds</option>"; // a=8,	b=2,	delay time = 13
	echo "<option value=3>  78 seconds</option>"; // a=10,	b=3,	delay time = 26
	echo "<option value=4> 159 seconds</option>"; // a=12,	b=4,	delay time = 53
	echo "<option value=5> 318 seconds</option>"; // a=14,	b=5,	delay time = 106
	echo "<option value=6> 639 seconds</option>"; // a=16,	b=6,	delay time = 213
	echo "</select>";
}

# slope filters are updated every 3 seconds, so have different delay time
function echoSlopeFilterSelect($filterName){
	echo "<select name=" . $filterName . " class=\"cc " . $filterName . "\">";
	echo "<option value=0>  27 seconds</option>"; // a=4,	b=0,	delay time = 3
	echo "<option value=1>  54 seconds</option>"; // a=6,	b=1,	delay time = 6
	echo "<option value=2>   2 minutes</option>"; // a=8,	b=2,	delay time = 13
	echo "<option value=3>   4 minutes</option>"; // a=10,	b=3,	delay time = 26
	echo "<option value=4>   8 minutes</option>"; // a=12,	b=4,	delay time = 53
	echo "<option value=5>  16 minutes</option>"; // a=14,	b=5,	delay time = 106
	echo "<option value=6>  32 minutes</option>"; // a=16,	b=6,	delay time = 213
	echo "</select>";
}

function echoYesNoSelect($optionName){
	echo "<select name=" . $optionName . " class=\"cc " . $optionName . "\">";
	echo "<option value=1> Yes</option>";
	echo "<option value=0>  No</option>";
	echo "</select>";
}
function echoRotarySelect($optionName){
	echo "<select name=" . $optionName . " class=\"cc " . $optionName . "\">";
	echo "<option value=0> Full step</option>";
	echo "<option value=1> Half step</option>";
	echo "</select>";
}
?>
<ul>
	<button class="script-status"></button>
	<li><a href="#settings"><span class="setting-name">Settings</span></a></li>
	<li><a href="#view-logs"><span>View logs</span></a></li>
	<li><a href="previous_beers.php"><span>Previous Beers</span></a></li>
	<li><a href="#control-algorithm"><span>Control Algorithm</span></a></li>
	<li><a href="#device-config"><span>Device Configuration</span></a></li>
	<li><a href="#advanced-settings"><span>Advanced Settings</span></a></li>
	<li><a href="#reprogram-arduino"><span>Reprogram <span class="boardMoniker">controller</span></span></a></li>
	<!--kinda dirty to have buttons in the ul, but the ul is styled as a nice header by jQuery UI -->
</ul>
<div id="reprogram-arduino">
	<p>Here you can upload a <span class="programFileType">firmware</span> file which will be uploaded to the <span class="boardMoniker">controller</span> by the Python script.
		The script will automatically restart itself after programming.
		Just hit the back button on your browser to continue running BrewPi.</p>
	<div id = "program-container">
		<!-- This form has a hidden iFrame as target, so the full page is not refreshed -->
		<form action="program_arduino.php" method="post" enctype="multipart/form-data" target="upload-target">
			<div id="program-options">
				<div class="program-option">
					<label for="file"><span class="programFileType">HEX</span> file:</label>
					<input type="file" name="file" id="file" /> <!-- add max file size?-->
				</div>
				<div class="program-option">
					<label for="boardType"> Board type:</label>
					<select name="boardType" class="boardType">
						<option value="leonardo">Leonardo</option>
						<option value="uno">Uno</option>
						<option value="atmega328">ATmega328 based</option>
						<option value="diecimila">Atmega168 based</option>
						<option value="mega2560">Mega 2560</option>
						<option value="mega">Mega 1280</option>
						<option value="core">Spark Core</option>
						<option value="photon">Particle Photon</option>
					</select>
				</div>
				<div class="program-option">
					<label for="restoreSettings">Restore old settings after programming</label>
					<input type="radio" name="restoreSettings" value="true" checked>Yes
					<input type="radio" name="restoreSettings" value="false">No
				</div>
				<div class="program-option">
					<label for="restoreDevices">Restore installed devices after programming</label>
					<input type="radio" name="restoreDevices" value="true" checked>Yes
					<input type="radio" name="restoreDevices" value="false">No
				</div>
			</div>
			<input id="program-submit-button" type="submit" name="Program" value="Program">
		</form>

		<h3 id="program-stderr-header">Script stderr output will auto-refresh while programming if you keep this tab open</h3>
		<div class="stderr console-box"></div>
		<iframe id="upload-target" name="upload-target" src="about:blank" style="width:0;height:0;border:0px solid #fff;"></iframe>
	</div>
</div>
<div id="settings">
	<div class="settings-container">
		<div class="setting-container">
			<span class="setting-name">Log data point every:</span>
			<select id="interval">
				<option value="10">10 Seconds</option>
				<option value="30">30 Seconds</option>
				<option value="60">1 Minute</option>
				<option value="120">2 Minutes</option>
				<option value="300">5 Minutes</option>
				<option value="600">10 Minutes</option>
				<option value="1800">30 Minutes</option>
				<option value="3600">1 hour</option>
			</select>
			<button id="apply-interval" class="apply-button">Apply</button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Date format:</span>
			<select id="datetime-format-display">
				<option <?php if ($dateTimeFormatDisplay == "mm/dd/yy") echo "selected=\"selected\""; ?>>mm/dd/yy</option>
				<option <?php if ($dateTimeFormatDisplay == "dd/mm/yy") echo "selected=\"selected\""; ?>>dd/mm/yy</option>
			</select>
			<button class="apply-datetime-format-display apply-button">Apply</button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Connection to BrewPi Spark</span>
			<div class="setting-group">
			<select id="connection-type">
				<option value="0">Serial port: </option>
				<option value="1">IP address:</option>
			</select>
			<input id="port-address">
			</div>
			<button class="apply-connection apply-button">Apply</button>
		</div>
	</div>
</div>
<div id="control-algorithm">
	<div class = "header ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
		<span class='container-title'>Controller state as JSON</span>
		<button class="cv update-from-arduino">Refresh</button>
	</div>
	<div class="algorithm-container ui-widget-content ui-corner-all">
		<pre class="json" id="algorithm-json">Click refresh to receive controller from device.</pre>
	</div>
</div>
<div id="advanced-settings">
	<div class = "header ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
		<span class='container-title'>Control settings</span>
		<button class="cs load-defaults">Reload defaults</button>
		<button class="cs receive-from-script">Receive from script</button>
		<button class="cs update-from-arduino">Update from <span class="boardMoniker">controller</span></button>
	</div>
	<div id="control-settings-container" class="ui-widget-content ui-corner-all">
		<div class="setting-container">
			<span class="setting-name">Mode</span>
			<span class="explanation">Active temperature control mode. Use to control panel to switch (apply button).</span>
			<select name="mode" class="cs mode">
				<option value="b">Beer Constant</option>
				<option value="p">Beer Profile</option>
				<option value="f">Fridge Constant</option>
				<option value="o">Off</option>
				<option value="t">Test mode</option>
			</select>
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Beer Temperature Setting</span>
			<span class="explanation">Beer temperature setting when in profile or beer constant mode. Use the control panel to adjust.</span>
			<input type="text" name="beerSet" class="cs beerSet">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Fridge Temperature Setting</span>
			<span class="explanation">Automatically adjust when in profile/beer constant mode. Use the control panel to adjust.</span>
			<input type="text" name="fridgeSet" class="cs fridgeSet">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
	</div>
	<div class = "header ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
		<span class='container-title'>Control constants</span>
		<button class="cc load-defaults">Reload defaults</button>
		<button class="cc receive-from-script">Receive from script</button>
		<button class="cc update-from-arduino">Update from <span class="boardMoniker">controller</span></button>
	</div>
	<div id="control-constants-container" class="ui-widget-content ui-corner-all">
		<div class="setting-container">
			<span class="setting-name">Temperature format</span>
			<span class="explanation">Switch your temperature format here. The algorithm always uses fixed point Celcius format internally,
				but it converts all settings that go in or out to the right format.</span>
			<select name="tempFormat" class="cc tempFormat">
				<option value="C">Celsius</option>
				<option value="F">Fahrenheit</option>
			</select>
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<span class="section-explanation">
			<p>
				This release runs on 3 PIDs (heater 2 is not used right now).
				The Heater 1 and Cooler PIDs take the fridge temperature as input and each drive a PWM actuator independently.
				However, only one actuator can be active at any time, with a dead time of 30 minutes for switching.
				Only the actuator with the highest value is activated, to prevent heating and cooling at the same time.
			</p>
			<p>
				When running in beer constant or profile mode, the Beer-to-Fridge PID determines the fridge setpoint.
				The PID output is added to the beer setting to give a fridge setting.
			</p>
			<p>
				Actuators are driven with PWM.
				For the cooler output, the compressor is guarded by minimum ON and OFF times.
				For PWM values below the minimum ON time, the PWM actuator will start skipping cycles to achieve the correct average.
			</p>
			<p>
				The gains of a PID controller can be obtained by trial and error method. Once an engineer understands the significance
				of each gain parameter, this method becomes relatively easy. In this method, the I and D terms are set to zero first
				and the proportional gain is increased until the output of the loop oscillates. As one increases the proportional gain,
				the system becomes faster, but care must be taken not make the system unstable. Once P has been set to obtain a desired
				fast response, the integral term is increased to stop the oscillations. The integral term reduces the steady state error,
				but increases overshoot. Some amount of overshoot is always necessary for a fast system so that it could respond to
				changes immediately. The integral term is tweaked to achieve a minimal steady state error. Once the P and I have been
				set to get the desired fast control system with minimal steady state error, the derivative term is increased until the
				loop is acceptably quick to its set point. Increasing derivative term decreases overshoot and yields higher gain with
				stability but would cause the system to be highly sensitive to noise. Often times, engineers need to tradeoff one
				characteristic of a control system for another to better meet their requirements.

				The Ziegler-Nichols method is another popular method of tuning a PID controller. It is very similar to the trial
				and error method wherein I and D are set to zero and P is increased until the loop starts to oscillate.
				Once oscillation starts, the critical gain Kc (in Brewpi that is the Kp) and the period of oscillations Pc are noted.
				The P, I and D are then adjusted as per the tabular column shown below.

				Control				P				Ti				Td
				P				0.5Kc				-				-
				PI				0.45Kc				Pc/1.2			-
				PID				0.60Kc				0.5Pc			Pc/8

				Parameter Increased	Rise Time		Overshoot		Settling Time	Steady-State Error	Stability
				Kp					Decrease		Increase		Small Change	Decrease			Degrade
				Ki					Decrease		Increase		Increase		Decrease 			Significantly	Degrade
				Kd					Minor Decrease	Minor Decrease	Minor Decrease	No Effect			Improve (for small Kd)


				The heater and cooler are tied to fridge temperature, not beer temperature. The fridge setpoint is determined by what
				the beer needs, so the heater and cooler are controlled by beer temperature indirectly.

				The fridge setting is calculated as follows:
				Fridge setpoint = Beer set point + Kp * beer temperature error + Ki * beer temperature error integral + Kd * beer temperature error derivative.
				Or in short, Fridge setpoint = beer setpoint + PID

				So slight variations in beer temperature (due to 0.0625 degree steps in temperature caused by digitization) are multiplied
				by Kp and result in a larger fluctuation in fridge setpoint.

				In the blue area, the fridge setpoint is 8C (beer setpoint + PID max). PID max can be configured in advanced settings
				and defaults to 10C. You just see the fridge cooling to the fridge setpoint and keeping it at 8C perfectly. The fluctuation
				in the fridge temp (blue line) is caused by minimum cycle times and physics.

				Highest peak is a result of the sharp derivative in beer temp. The setpoint fluctuates a bit due to fluctuations in beer temp,
				mostly caused by the digital nature of the sensor. The reason they are not staircases is that the sensor signal is filtered.

				Fridge setpoint is set to 5C (again beer setpoint - PIDMAX), fridge cools to that point. When the beer temp comes closer
				to setpoint, the PID result decreases, mainly because P decreases). As the beer temp comes closer to setpoint, the fridge and
				beer setpoint approach each other.

				So to summarize: the algorithm uses cascaded PID: the fridge setting is adjusted to what the beer needs and the actuators are
				tied to the fridge setpoint/temperature. They predict overshoot and turn of prematurely when overshoot is expected.

				If you wonder where the fridge setpoint is coming from, take a look at the control algorithm page in the web interface.

		</span>

		<div class="setting-container">
			<span class="setting-name">Beer-to-Fridge proportional gain (Kp)</span>
			<span class="explanation">Actuatour output in % = Kp * input error. For instance,
			if the error term has a magnitude of 10, a proportional gain of 5 would produce a
			proportional response of 50. In general, increasing the proportional gain will
			increase the speed of the control system response. However, if the proportional
			gain is too large, the process variable will begin to oscillate.</span>
			<input type="text" name="beer2fridge_kp" class="cc beer2fridge_kp">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Beer-to-Fridge integral time constant (Ti)</span>
			<span class="explanation">The input error is slowly accumulated in the integrator.
			A steady state error that is not corrected by Kp, is corrected by the integral.
			The integral part grows by the proportional part every Ti seconds.
			If you let it grow to quickly, this can create overshoot. Be careful.
			The integral response will continually increase over time unless the error is zero,
			so the effect is to drive the Steady-State error to zero. Steady-State error is
			the final difference between the process variable and set point. A phenomenon
			called integral windup results when integral action saturates a controller without
			the controller driving the error signal toward zero.
			</span>
			<input type="text" name="beer2fridge_ti" class="cc beer2fridge_ti">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Beer-to-Fridge derivative time constant (Td)</span>
			<span class="explanation">The derivative is the temperature difference per second. The derivative part of PID is -Kp * Td * dT/dt.
				This can be interpreted as looking Td seconds ahead.
				For very slow processes (like fermentation), it is recommended to disable the derivative gain by setting it to zero.
				The limited sensor resolution will make it hard to distinguish bit flips from rises in temperature.
				The derivative component causes the output to decrease if the process
				variable is increasing rapidly. The derivative response is proportional
				to the rate of change of the process variable. Increasing the derivative time (Td)
				parameter will cause the control system to react more strongly to changes in the
				error term and will increase the speed of the overall control system response. Most
				practical control systems use very small derivative time (Td), because the Derivative
				Response is highly sensitive to noise in the process variable signal. If the sensor
				feedback signal is noisy or if the control loop rate is too slow, the derivative
				response can make the control system unstable
			</span>
			<input type="text" name="beer2fridge_td" class="cc beer2fridge_td">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
		    <span class="setting-name">Maximum difference between fridge and beer set point (= output of PID)</span>
			<span class="explanation">The output of this PID is added to the beer set point to automatically set the fridge set point.
			You can define the maximum difference between the beer temperature setting and fridge temperature setting here.
			</span>
			<input type="text" name="beer2fridge_pidMax" class="cc beer2fridge_pidMax">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
        </div>

		<div class="setting-container">
			<span class="setting-name">Beer-to-Fridge Input filter delay time</span>
			<span class="explanation">Input to the PID is filtered. This causes a delay, because of the moving average. More delay means more filtering.</span>
			<?php echoFilterSelect("beer2fridge_infilt") ?>
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Beer-to-Fridge Derivative filter delay time</span>
			<span class="explanation">Input to the differential gain is filtered, to prevent bit flips from causing a high derivative.
				This causes a delay, because of the moving average. More delay means more filtering.</span>
			<?php echoFilterSelect("beer2fridge_dfilt") ?>
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>

		<div class="setting-container">
			<span class="setting-name">Cooler proportional gain (Kp)</span>
			<span class="explanation">Actuatour output in % = Kp * input error</span>
			<input type="text" name="cooler_kp" class="cc cooler_kp">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Cooler integral time constant (Ti)</span>
			<span class="explanation">The input error is slowly accumulated in the integrator.
			A steady state error that is not corrected by Kp, is corrected by the integral.
			The integral part grows by the proportional part every Ti seconds.
			If you let it grow to quickly, this can create overshoot. Be careful.
			</span>
			<input type="text" name="cooler_ti" class="cc cooler_ti">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Cooler derivative time constant (Td)</span>
			<span class="explanation">The derivative is the temperature difference per second. The derivative part of PID is -Kp * Td * dT/dt.
				This can be interpreted as looking Td seconds ahead.
				For very slow processes (like fermentation), it is recommended to disable the derivative gain by setting it to zero.
				The limited sensor resolution will make it hard to distinguish bit flips from rises in temperature.
			</span>
			<input type="text" name="cooler_td" class="cc cooler_td">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Cooler PWM period (seconds)</span>
			<span class="explanation">Each PWM cycle takes this many seconds. A value lower than 4 seconds is not recommended.</span>
			<input type="text" name="coolerPwmPeriod" class="cc coolerPwmPeriod">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Cooler minimum OFF time</span>
			<span class="explanation">A fridge compressor needs to be OFF for a minimum time to protect it from building up pressure and overheating.</span>
			<input type="text" name="minCoolIdleTime" class="cc minCoolIdleTime">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Cooler minimum ON time</span>
			<span class="explanation">A minimum ON time is also recommended, because many short cycles limit the compressor lifespan.</span>
			<input type="text" name="minCoolTime" class="cc minCoolTime">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Cooler Input filter delay time</span>
			<span class="explanation">Input to the PID is filtered. This causes a delay, because of the moving average. More delay means more filtering.</span>
			<?php echoFilterSelect("cooler_infilt") ?>
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Cooler Derivative filter delay time</span>
			<span class="explanation">Input to the differential gain is filtered, to prevent bit flips from causing a high derivative.
				This causes a delay, because of the moving average. More delay means more filtering.</span>
			<?php echoFilterSelect("cooler_dfilt") ?>
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>

		<div class="setting-container">
			<span class="setting-name">Heater 1 proportional gain (Kp)</span>
			<span class="explanation">Actuatour output in % = Kp * input error</span>
			<input type="text" name="heater1_kp" class="cc heater1_kp">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Heater 1 integral time constant (Ti)</span>
			<span class="explanation">The input error is slowly accumulated in the integrator.
			A steady state error that is not corrected by Kp, is corrected by the integral.
			The integral part grows by the proportional part every Ti seconds.
			If you let it grow to quickly, this can create overshoot. Be careful.
			</span>
			<input type="text" name="heater1_ti" class="cc heater1_ti">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Heater 1 derivative time constant (Td)</span>
			<span class="explanation">The derivative is the temperature difference per second. The derivative part of PID is -Kp * Td * dT/dt.
				This can be interpreted as looking Td seconds ahead.
				For very slow processes (like fermentation), it is recommended to disable the derivative gain by setting it to zero.
				The limited sensor resolution will make it hard to distinguish bit flips from rises in temperature.
			</span>
			<input type="text" name="heater1_td" class="cc heater1_td">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Heater 1 PWM period (seconds)</span>
            <span class="explanation">Each PWM cycle takes this many seconds. A value lower than 4 seconds is not recommended.</span>
			<input type="text" name="heater1PwmPeriod" class="cc heater1PwmPeriod">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Heater 1 Input filter delay time</span>
			<span class="explanation">Input to the PID is filtered. This causes a delay, because of the moving average. More delay means more filtering.</span>
			<?php echoFilterSelect("heater1_infilt") ?>
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Heater 1 Derivative filter delay time</span>
			<span class="explanation">Input to the differential gain is filtered, to prevent bit flips from causing a high derivative.
				This causes a delay, because of the moving average. More delay means more filtering.</span>
			<?php echoFilterSelect("heater1_dfilt") ?>
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>

		<div class="setting-container">
			<span class="setting-name">Heater 2 proportional gain (Kp)</span>
			<span class="explanation">Actuatour output in % = Kp * input error</span>
			<input type="text" name="heater2_kp" class="cc heater2_kp">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Heater 2 integral time constant (Ti)</span>
			<span class="explanation">The input error is slowly accumulated in the integrator.
			A steady state error that is not corrected by Kp, is corrected by the integral.
			The integral part grows by the proportional part every Ti seconds.
			If you let it grow to quickly, this can create overshoot. Be careful.
			</span>
			<input type="text" name="heater2_ti" class="cc heater2_ti">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Heater 2 derivative time constant (Td)</span>
			<span class="explanation">The derivative is the temperature difference per second. The derivative part of PID is -Kp * Td * dT/dt.
				This can be interpreted as looking Td seconds ahead.
				For very slow processes (like fermentation), it is recommended to disable the derivative gain by setting it to zero.
				The limited sensor resolution will make it hard to distinguish bit flips from rises in temperature.
			</span>
			<input type="text" name="heater2_td" class="cc heater2_td">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Heater 2 PWM period (seconds)</span>
			<span class="explanation">Each PWM cycle takes this many seconds. A value lower than 4 seconds is not recommended.</span>
			<input type="text" name="heater2PwmPeriod" class="cc heater2PwmPeriod">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Heater 2 Input filter delay time</span>
			<span class="explanation">Input to the PID is filtered. This causes a delay, because of the moving average. More delay means more filtering.</span>
			<?php echoFilterSelect("heater2_infilt") ?>
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
		<div class="setting-container">
			<span class="setting-name">Heater 2 Derivative filter delay time</span>
			<span class="explanation">Input to the differential gain is filtered, to prevent bit flips from causing a high derivative.
				This causes a delay, because of the moving average. More delay means more filtering.</span>
			<?php echoFilterSelect("heater2_dfilt") ?>
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>
        <div class="setting-container">
			<span class="setting-name">Dead time when switching between actuators</span>
			<span class="explanation">Only one can be active at each moment. The dead time is the minimum to wait when switching between one actuator and another.
			This prevents quickly alternating between heating to cooling.</span>
			<input type="text" name="deadTime" class="cc deadTime">
			<button class="send-button">Send to <span class="boardMoniker">controller</span></button>
		</div>

		<span class="section-explanation">
			<p>With the button below, you can reset the entire <span class="boardMoniker">controller</span> to factory defaults.</p>
			<p>This will reset all settings and will remove all installed devices.</p>
			<button class="reset-controller-button">Reset <span class="boardMoniker">controller</span> to factory defaults</button>
		</span>
	</div>
</div>

<div id="device-config">
	<div class="console-box" id="device-console">
		<span></span>
	</div>
	<div class = "header ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
		<span class='container-title'>Device List</span>
		<div class="refresh-options-container">
			<div class="refresh-option">
				<input type="checkbox" name="read-values" id="read-values" /><label for="read-values">Read values</label>
			</div>
		</div>
		<button class="refresh-device-list">Refresh device list</button>
	</div>
	<div class="device-list-container ui-widget-content ui-corner-all">
		<div class ="spinner-position"></div>
		<div class="device-list"></div>
	</div>
</div>

<div id="view-logs">
	<div id="log-buttons" style="clear:both">
		<button id="erase-logs">Erase logs</button>
		<button id="auto-refresh-logs">Enable auto refresh</button>
		<button id="refresh-logs">Refresh</button>
	</div>
	<h3>stderr:</h3>
	<div class="stderr console-box"></div>
	<h3>stdout:</h3>
	<div class="stdout console-box"></div>
</div>
